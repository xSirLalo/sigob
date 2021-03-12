<?php

declare(strict_types=1);

namespace Catastro\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Laminas\View\Model\JsonModel;
use Laminas\Paginator\Paginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Catastro\Form\PredioForm;
use Catastro\Entity\Predio;
use Catastro\Entity\Contribuyente;
use Catastro\Entity\PredioColindancia;
use Catastro\Form\BibliotecaForm;

class PredioController extends AbstractActionController
{
    /**
     * Entity manager.
     * @var Doctrine\ORM\EntityManager
     */
    private $entityManager;
    /**
     * Predio Manager.
     * @var Catastro\Service\PredioManager
     */
    private $predioManager;
    private $bibliotecaManager;
    private $opergobserviceadapter;

    public function __construct($entityManager, $predioManager, $bibliotecaManager, $opergobserviceadapter)
    {
        $this->entityManager = $entityManager;
        $this->predioManager = $predioManager;
        $this->bibliotecaManager = $bibliotecaManager;
        $this->opergobserviceadapter = $opergobserviceadapter;
    }

    public function indexAction()
    {
        $page = $this->params()->fromQuery('page', 1);
        $query = $this->entityManager->getRepository(Predio::class)->createQueryBuilder('p')->getQuery();

        $adapter = new DoctrineAdapter(new ORMPaginator($query, false));
        $paginator = new Paginator($adapter);
        $paginator->setDefaultItemCountPerPage(10);
        $paginator->setCurrentPageNumber($page);

        return new ViewModel(['predios' => $paginator]);
    }

    public function addAction()
    {
        // https://stackoverflow.com/questions/2194317/how-to-combine-two-zend-forms-into-one-zend-form
        $form = new PredioForm();
        $form2 = new BibliotecaForm();
        $categorias = $this->bibliotecaManager->categorias();

        $request = $this->getRequest();

        if ($request->isPost()) {
            $data = $this->params()->fromPost();
            $form->setData($data);
            if ($form->isValid()) {
                $data = $form->getData();

                $predio = $this->entityManager->getRepository(Predio::class)->findOneByClaveCatastral($data['cve_catastral']);
                if ($predio) {
                    $this->predioManager->actualizar($predio, $data);
                    $this->flashMessenger()->addSuccessMessage('Se actualizo con éxito!');
                } else {
                    $this->predioManager->guardar($data);
                    $this->flashMessenger()->addSuccessMessage('Se agrego con éxito!');
                }

                return $this->redirect()->toRoute('predio');
            }
        }
        return new ViewModel(['form' => $form, 'form2' => $form2, 'categorias' => $categorias]);
    }

    public function viewAction()
    {
        return new ViewModel();
    }

    public function editAction()
    {
        return new ViewModel();
    }
    public function search1CatastralAction()
    {
        $word = $_REQUEST['q'];

        $qb = $this->entityManager->createQueryBuilder();

        $qb ->select('p')
                ->from('Catastro\Entity\Predio', 'p')
                    ->where('p.claveCatastral LIKE :word')
                    ->setParameter("word", '%'.addcslashes($word, '%_').'%');
        $query = $qb->getQuery()->getResult();

        $arreglo  = [];
        foreach ($query as $r) {
            $arreglo [] = [
                    'id' => $r->getClaveCatastral(),
                    'item_select_name'=> $r->getClaveCatastral() . ' - ' . $r->getTitular(),
                ];
        }
        $data = [
                    'items'       => $arreglo,
                    'total_count' => count($arreglo),
                ];

        $json = new JsonModel($data);
        $json->setTerminal(true);

        return $json;
    }

    public function searchCatastralAction()
    {
        $word = $_REQUEST['q'];

        $qb = $this->entityManager->createQueryBuilder();

        $qb ->select('p')
                ->from('Catastro\Entity\Predio', 'p')
                    ->where('p.claveCatastral LIKE :word')
                    ->setParameter("word", '%'.addcslashes($word, '%_').'%');
        $query = $qb->getQuery()->getResult();

        $arreglo  = [];
        if ($query) {
            foreach ($query as $r) {
                $arreglo [] = [
                        'id' => $r->getClaveCatastral(),
                        'item_select_name'=> $r->getClaveCatastral() . ' - ' . $r->getTitular(),
                    ];
            }
        } else {
            $WebService = $this->opergobserviceadapter->obtenerPredio($word);
            $WebServicePredio = [
                'colonia'                 => $WebService->Predio->NombreColonia,
                'localidad'               => $WebService->Predio->NombreLocalidad,
                'municipio'               => $WebService->Predio->NombreMunicipio,
                'calle'                   => $WebService->Predio->PredioCalle,
                'cve_catastral'           => $WebService->Predio->PredioCveCatastral,
                'cve_predio'              => $WebService->Predio->PredioId,
                'numero_exterior'         => $WebService->Predio->PredioNumExt,
                'numero_interior'         => $WebService->Predio->PredioNumInt,
                'estatus'                 => $WebService->Predio->PredioStatus,
                'tipo'                    => $WebService->Predio->PredioTipo,
                'ultimo_ejercicio_pagado' => $WebService->Predio->PredioUltimoEjercicioPagado,
                'ultimo_periodo_pagado'   => $WebService->Predio->PredioUltimoPeriodoPagado,
                'titular'                 => $WebService->Predio->Titular,
                'titular_anterior'        => $WebService->Predio->TitularCompleto,
            ];

            $WebService2 = $this->opergobserviceadapter->obtenerPersonaPorCve($WebService->Predio->CvePersona);
            $WebServicePersona = [
                'apellido_paterno' => $WebService2->Persona->ApellidoPaternoPersona,
                'apellido_materno' => $WebService2->Persona->ApellidoMaternoPersona,
                'curp'             => $WebService2->Persona->CURPPersona,
                'cve_persona'      => $WebService2->Persona->CvePersona,
                'genero'           => $WebService2->Persona->GeneroPersona,
                'nombre'           => $WebService2->Persona->NombrePersona,
                'telefono'         => $WebService2->Persona->PersonaTelefono,
                'correo'           => $WebService2->Persona->PersonaCorreo,
                'rfc'              => $WebService2->Persona->RFCPersona,
                'razon_social'     => $WebService2->Persona->RazonSocialPersona,
            ];

            $contribuyente = $this->predioManager->guardarPersona($WebServicePersona);

            if ($contribuyente > 0) {
                $this->predioManager->guardarPredio($contribuyente, $WebServicePredio);
            }

            $arreglo[] = [
                        'id' => $WebService->Predio->PredioCveCatastral,
                        'item_select_name' => $WebService->Predio->PredioCveCatastral,
                    ];
        }

        $data = [
                    'items'       => $arreglo,
                    'total_count' => count($arreglo),
                ];

        $json = new JsonModel($data);
        $json->setTerminal(true);

        return $json;
    }

    public function autofillCatastralAction()
    {
        $request = $this->getRequest();
        $response = $this->getResponse();
        // AJAX response
        if ($request->isXmlHttpRequest()) {
            $word = $this->params()->fromRoute('id');

            $qb = $this->entityManager->createQueryBuilder();

            $qb ->select('p')
                    ->from('Catastro\Entity\Predio', 'p')
                        ->where('p.claveCatastral LIKE :word')
                        ->setParameter("word", '%'.addcslashes($word, '%_').'%');
            $query = $qb->getQuery()->getResult();

            $data = [];
            if ($query) {
                foreach ($query as $r) {
                    $data = [
                        'titular'          => $r->getTitular(),
                        'localidad'        => $r->getLocalidad(),
                        'titular_anterior' => $r->getTitularAnterior(),
                        'predio_id'        => $r->getIdPredio(),
                    ];
                }
            } else {
                $WebService = $this->opergobserviceadapter->obtenerPredio($word);
                $WebService2 = $this->opergobserviceadapter->obtenerColindancia($WebService->Predio->PredioId);

                $data = [
                        'titular'          => $WebService->Predio->Titular,
                        'localidad'        => $WebService->Predio->NombreLocalidad,
                        'titular_anterior' => $WebService->Predio->TitularCompleto,
                        'predio_id'        => $WebService->Predio->PredioId,
                        'con_norte'        => $WebService2->PredioColindancia[0]->Descripcion,
                        'con_sur'          => $WebService2->PredioColindancia[1]->Descripcion,
                        'con_este'         => $WebService2->PredioColindancia[2]->Descripcion,
                        'con_oeste'        => $WebService2->PredioColindancia[3]->Descripcion,
                        'norte'            => $WebService2->PredioColindancia[0]->MedidaMts,
                        'sur'              => $WebService2->PredioColindancia[1]->MedidaMts,
                        'este'             => $WebService2->PredioColindancia[2]->MedidaMts,
                        'oeste'            => $WebService2->PredioColindancia[3]->MedidaMts,
                    ];
            }

            return $response->setContent(json_encode($data));
        } else {
            echo 'Error get data from ajax';
        }
    }
}
