<?php

declare(strict_types=1);

namespace Catastro\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Laminas\View\Model\JsonModel;
use Laminas\Paginator\Paginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Catastro\Form\AportacionModalForm;
use Catastro\Form\AportacionForm;
use Catastro\Form\ValidacionForm;
use Catastro\Entity\Predio;
use Catastro\Entity\PredioColindancia;
use Catastro\Entity\Aportacion;
use Catastro\Entity\TablaValorConstruccion;

class AportacionController extends AbstractActionController
{
    /**
     * Entity manager.
     * @var Doctrine\ORM\EntityManager
     */
    private $entityManager;
    /**
     * Aportacion Manager.
     * @var Catastro\Service\AportacionManager
     */
    private $aportacionManager;
    private $opergobserviceadapter;

    public function __construct($entityManager, $aportacionManager, $opergobserviceadapter)
    {
        $this->entityManager = $entityManager;
        $this->aportacionManager = $aportacionManager;
        $this->opergobserviceadapter = $opergobserviceadapter;
    }

    public function indexAction()
    {
        $form = new AportacionModalForm();
        $page = $this->params()->fromQuery('page', 1);
        $query = $this->entityManager->getRepository(Aportacion::class)->createQueryBuilder('a')->getQuery();

        $adapter = new DoctrineAdapter(new ORMPaginator($query, false));
        $paginator = new Paginator($adapter);
        $paginator->setDefaultItemCountPerPage(10);
        $paginator->setCurrentPageNumber($page);

        return new ViewModel(['aportaciones' => $paginator, 'form' => $form]);
    }

    public function datatableAction()
    {
        $request = $this->getRequest();
        $response = $this->getResponse();

        $qb = $this->entityManager->createQueryBuilder()->select('a')->from('Catastro\Entity\Aportacion', 'a');

        $query = $qb->getQuery()->getResult();

        $data = [];

        foreach ($query as $r) {
            $data[] = [
                    'idAportacion'  => $r->getIdAportacion(),
                    'Contribuyente' => $r->getIdContribuyente()->getNombre(),
                    'Titular'       => $r->getIdPredio()->getTitular(),
                    'Fecha'         => $r->getFecha()->format('d-m-Y'),
                    'Estatus'       => $r->getEstatus(),
                    'opciones'      => "Cargando..."
                ];
        }
        $result = [
                    "draw"            => 1,
                    "recordsTotal"    => count($data),
                    "recordsFiltered" => count($data),
                    'aaData'            => $data,
                ];

        $json = new JsonModel($result);
        $json->setTerminal(true);
        return $json;
    }

    public function addAction()
    {
        $form = new AportacionForm();

        $parametro = (string)$this->params()->fromRoute('id');

        $aportacion =$this->entityManager->getRepository(Aportacion::class)->findAll();
        $valorConstruccion = $this->entityManager->getRepository(TablaValorConstruccion::class)->findAll();

        $request = $this->getRequest();

        if ($request->isPost()) {
            $data = $this->params()->fromPost();
            $form->setData($data);
            if ($form->isValid()) {
                $data = $form->getData();
                $this->aportacionManager->guardar($data);
                $this->aportacionManager->pdf($data);
                $this->flashMessenger()->addSuccessMessage('Se agrego con éxito!');
                return $this->redirect()->toRoute('aportacion');
            }
        }
        return new ViewModel(['form' => $form, 'id' => $parametro, 'valorConstruccions' => $valorConstruccion]);
    }

    public function addModalAction()
    {
        $form = new AportacionModalForm();
        $request = $this->getRequest();
        $response = $this->getResponse();

        if ($request->isXmlHttpRequest()) {
            if ($request->isPost()) {
                $data = $this->params()->fromPost();
                $form->setData($request->getPost());
                if ($form->isValid()) {
                    $data = $form->getData();
                    $data['estatus'] = true;
                    $this->aportacionManager->guardarModal($data);
                } else {
                    $data['status'] = false;
                    $data['errors'] = $form->getMessages();
                };
                $response->setContent(\Laminas\Json\Json::encode($data));
                return $response;
            }
        } else {
            echo 'Error get data from ajax';
        }
    }

    public function validationAction()
    {
        // $this->layout()->setTemplate('catastro/aportacion/index-validation');

        $aportaciones = $this->entityManager->getRepository(Aportacion::class)->findAll();

        $form = new ValidacionForm();
        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $form->setData($data);
            if ($form->isValid()) {
                $data = $form->getData();
                $aportacion = $this->entityManager->getRepository(Aportacion::class)->findOneByIdAportacion($data['padron_id']);

                $this->aportacionManager->update($aportacion, $data);

                return $this->redirect()->toRoute('aportacion/validacion');
            }
        }

        return new ViewModel(['aportaciones' => $aportaciones, 'form' => $form]);
    }

    public function searchRfcAction()
    {
        $name = $_REQUEST['q'];

        ///Join ala base de datos para hacer el select
        $qb = $this->entityManager->createQueryBuilder();
        $qb->select('c')->from('Catastro\Entity\Contribuyente', 'c')
                ->where($qb->expr()->like('c.nombre', ":word"))
                ->orWhere($qb->expr()->like('c.apellidoPaterno', ":word"))
                ->orWhere($qb->expr()->like('c.apellidoMaterno', ":word"))
                ->orWhere($qb->expr()->like('c.rfc', ":word"))
            ->setParameter("word", '%' . addcslashes($name, '%_') . '%');
        $datos = $qb->getQuery()->getResult();

        //si no exciste el contribuyente en la base datos buscar por rfc en el web service
        if ($datos == null) {
            $resultados = $this->opergobserviceadapter->obtenerPersonaPorRfc($name);
            $arreglo = [];
            $arreglo[] = [
                'id' => $resultados->Persona[0]->RFCPersona,
                'titular' => $resultados->Persona[0]->RFCPersona . ' - '. $resultados->Persona[0]->RazonSocialPersona,
            ];
            $data = [
                'items' => $arreglo,
                'total_count' => count($arreglo),
            ];
        } else {
            $arreglo = [];
            foreach ($datos as $dato) {
                $arreglo[] = [
                    'id' => $dato->getIdContribuyente(),
                    'titular' => $dato->getNombre(). ' ' .$dato->getApellidoPaterno(). ' ' .$dato->getApellidoMaterno() ,
                ];
            }
            $data = [
                'items' => $arreglo,
                'total_count' => count($arreglo),
            ];
        }
        $json = new JsonModel($data);
        $json->setTerminal(true);

        return $json;
    }

    public function searchCatastralAction()
    {
        $name = $_REQUEST['q'];
        $resultados = $this->opergobserviceadapter->obtenerPredio($name);
        $arreglo = [];
        $arreglo[] = [
                'id' => $resultados->Predio->PredioCveCatastral,
                'titular' => $resultados->Predio->PredioCveCatastral,
            ];
        $data = [
                'items' => $arreglo,
                'total_count' => count($arreglo),
            ];
        $json = new JsonModel($data);
        $json->setTerminal(true);
        return $json;
    }

    public function autofillRfcAction()
    {
        $request = $this->getRequest();
        $response = $this->getResponse();
        // AJAX response
        if ($request->isXmlHttpRequest()) {
            $id = $this->params()->fromRoute('id');
            $aportacion = $this->entityManager->getRepository(Aportacion::class)->findOneByIdContribuyente($id);
            $predioColindacias = $this->entityManager->getRepository(PredioColindancia::class)->findOneByIdPredio($id);
            $predio = $this->entityManager->getRepository(Predio::class)->findOneByIdPredio($id);
            $data = [
                'titular' => $aportacion->getIdPredio()->getTitular(),
                'ubicacion' => $aportacion->getIdPredio()->getUbicacion(),
                'titular_anterior' => $aportacion->getIdPredio()->getTitularAnterior(),
                'id_predio'=> $aportacion->getIdPredio()->getIdPredio(),
                'cvlCatastral'=> $aportacion->getIdPredio()->getClaveCatastral(),
            ];

            return $response->setContent(json_encode($data));
        } else {
            echo 'Error get data from ajax';
        }
    }

    public function autofillCatastralAction()
    {
        $request = $this->getRequest();
        $response = $this->getResponse();
        // AJAX response
        if ($request->isXmlHttpRequest()) {
            $id = $this->params()->fromRoute('id');

            $resultados = $this->opergobserviceadapter->obtenerPredio($id);
            $colindancia = $this->opergobserviceadapter->obtenerColindancia($resultados->Predio->PredioId);
            // TODO: Corregir Titular anterior
            $data = [
                'titular'          => $resultados->Predio->Titular,
                'ubicacion'        => $resultados->Predio->NombreLocalidad,
                'titular_anterior' => $resultados->Predio->TitularCompleto,
                'cvepredio'        => $resultados->Predio->PredioId,

                'con_norte'        => $colindancia->PredioColindancia[0]->Descripcion,
                'con_sur'          => $colindancia->PredioColindancia[1]->Descripcion,
                'con_este'         => $colindancia->PredioColindancia[2]->Descripcion,
                'con_oeste'        => $colindancia->PredioColindancia[3]->Descripcion,

                'norte'            => $colindancia->PredioColindancia[0]->MedidaMts,
                'sur'              => $colindancia->PredioColindancia[1]->MedidaMts,
                'este'             => $colindancia->PredioColindancia[2]->MedidaMts,
                'oeste'            => $colindancia->PredioColindancia[3]->MedidaMts,
            ];

            return $response->setContent(json_encode($data));
        } else {
            echo 'Error get data from ajax';
        }
    }

    public function validateAction()
    {
        $aportacion = $this->entityManager->getRepository(Aportacion::class)->findAll();
        $form = new ValidacionForm();
        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $form->setData($data);
            if ($form->isValid()) {
                $data = $form->getData();
                $aportacion = $this->entityManager->getRepository(Aportacion::class)->findOneByIdAportacion($data['padron_id']);
                $this->aportacion->update($aportacion, $data);
                return $this->redirect()->toRoute('aportacion/validacion');
            }
        }
        return new ViewModel(['aportaciones' => $aportacion, 'form' => $form]);
    }
}
