<?php

declare(strict_types=1);

namespace Catastro\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Laminas\View\Model\JsonModel;
use Laminas\Paginator\Paginator;
use Laminas\Filter;
use Laminas\InputFilter\OptionalInputFilter;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Catastro\Form\PredioForm;
use Catastro\Entity\Predio;
use Catastro\Entity\PredioColindancia;
use Catastro\Entity\Archivo as Biblioteca;
use Catastro\Entity\Contribuyente;
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
        $categorias = $this->bibliotecaManager->categorias();
        $destination = './public/img';
        $request = $this->getRequest();
        if ($request->isPost()) {
            $data = \array_merge_recursive(
                $request->getFiles()->toArray(),
                $request->getPost()->toArray(),
            );
            // $data = $this->params()->fromPost();
            $archivoUrl = (array) $this->params()->fromFiles('archivo');
            $archivoUrl = array_slice($archivoUrl, 0, 5); # we restrict to 5 fields i meant

            $categoria = (array) $this->params()->fromPost('id_archivo_categoria');
            $categoria = array_slice($categoria, 0, 5); # we restrict to 5 fields i meant
            $num = (int) count($archivoUrl);
            for ($i=0; $i < $num; $i++) {
                $newName = strtolower(str_replace(" ", "-", $archivoUrl[$i]['name']));

                $file_folder = $destination . '/' . $newName;

                if (file_exists($file_folder)) {
                    // FIXME: Vacio aun asi muestra el mensaje
                    $this->flashMessenger()->addErrorMessage('El archivo existe! ' . $newName);
                    return $this->redirect()->toRoute('predio/agregar');
                }

                $inputFilter = new OptionalInputFilter();
                $inputFilter->add([
                    'name' => 'archivo',
                    'filters' => [
                        [
                            'name' => Filter\File\Rename::class,
                            'options' => [
                                'target' => $destination . '/' . $newName,
                            ]
                        ]
                    ]
                ]);
                $form->setInputFilter($inputFilter);
            }

            $form->setData($data);
            if ($form->isValid()) {
                $data = $form->getData();
                $archivoUrl = (array) $this->params()->fromFiles('archivo');
                $archivoUrl = array_slice($archivoUrl, 0, 5); # we restrict to 5 fields i meant

                $categorias = (array) $this->params()->fromPost('id_archivo_categoria');
                $categorias = array_slice($categorias, 0, 5); # we restrict to 5 fields i meant

                $num = (int) count($archivoUrl);
                for ($i=0; $i < $num; $i++) {
                    $filename = $_FILES['archivo']['name'][$i];
                    $filesize = $_FILES['archivo']['size'][$i];
                    $tmp_name = $_FILES['archivo']['tmp_name'][$i];
                    $file_type = $_FILES['archivo']['type'][$i];
                    $date = date("d-m-Y_H-i");
                    $temp = explode(".", $filename);
                    $new_filename =   strtolower(str_replace(" ", "-", $temp[0])) . '.' . $temp[count($temp)-1];
                    $file_folder = $destination . '/' . $new_filename;

                    $data['archivoBlob'] = file_get_contents($file_folder, true);
                    $data['extension'] = $temp[count($temp)-1];
                    $data['size'] = $filesize;
                    $data['archivoUrl'] = strtolower(str_replace(" ", "-", $archivoUrl[$i]['name']));
                    $data['categoria'] = $categoria[$i];
                    $id = $data['input1'];

                    $archivito = $this->bibliotecaManager->guardarArchivos($data, $categoria[$i]);

                    if ($archivito) {
                        $this->bibliotecaManager->guardarRelacionAP($id, $archivito);
                    }

                    $predio = $this->entityManager->getRepository(Predio::class)->findOneByClaveCatastral($data['cve_catastral']);
                    if ($predio) {
                        $this->predioManager->actualizarPredio($predio, $data);
                        $this->flashMessenger()->addSuccessMessage('Se actualizo con éxito!');
                    } else {
                        $this->predioManager->guardarPredio($data);
                        $this->flashMessenger()->addSuccessMessage('Se agrego con éxito!');
                    }
                }
                // $data = $form->getData();

                return $this->redirect()->toRoute('predio');
            }
        }
        return new ViewModel(['form' => $form, 'categorias' => $categorias]);
    }

    public function viewAction()
    {
        $predioId = (int)$this->params()->fromRoute('id', -1);

        if ($predioId < 0) {
            $this->layout()->setTemplate('error/404');
            $this->getResponse()->setStatusCode(404);
            return $response->setTemplate('error/404');
        }

        $predio     = $this->entityManager->getRepository(Predio::class)->findOneByIdPredio($predioId);

        $qb = $this->entityManager->createQueryBuilder();
        $qb->select('p')
            ->from('Catastro\Entity\PredioColindancia', 'p')
            ->where('p.idPredio = :idParam')
            ->setParameter('idParam', $predioId);
        $predioColindancias = $qb->getQuery()->getResult();

        $qb = $this->entityManager->createQueryBuilder();
        $qb ->select('ap')
            ->from('Catastro\Entity\ArchivoPredio', 'ap')
            ->join('Catastro\Entity\Predio', 'p', \Doctrine\ORM\Query\Expr\Join::WITH, 'ap.idPredio = p.idPredio')
            ->join('Catastro\Entity\Archivo', 'a', \Doctrine\ORM\Query\Expr\Join::WITH, 'a.idArchivo = ap.idArchivo')
            ->join('Catastro\Entity\ArchivoCategoria', 'ac', \Doctrine\ORM\Query\Expr\Join::WITH, 'ac.idArchivoCategoria = a.idArchivoCategoria')
            ->where('ap.idPredio = :idParam')
            ->setParameter('idParam', $predioId)
            ->orderBy('ap.idArchivo', 'ASC');

        $archivos = $qb->getQuery()->getResult();

        if ($predio == null) {
            $this->layout()->setTemplate('error/404');
            $this->getResponse()->setStatusCode(404);
            return $response->setTemplate('error/404');
        }

        return new ViewModel(['predio' => $predio, 'colindancias' => $predioColindancias, 'archivos' => $archivos, 'predioId' => $predioId]);
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

            if ($contribuyente) {
                $predio = $this->predioManager->guardarPredio($contribuyente, $WebServicePredio);
            }

            $WebService3 = $this->opergobserviceadapter->obtenerColindancia($WebService->Predio->PredioId);

            foreach ($WebService3->PredioColindancia as $item) {
                $WebServiceColindancia = [
                    'medida_metros'            => $item->MedidaMts,
                    'descripcion'              => $item->Descripcion,
                    'orientacion_geografica'   => $item->OrientacionGeografica,
                ];
                if ($predio) {
                    $this->predioManager->guardarColindancia($predio, $WebServiceColindancia);
                }
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
                    $idpredio = $r->getIdPredio();
                    $qb = $this->entityManager->createQueryBuilder();
                    $qb ->select('p')
                        ->from('Catastro\Entity\PredioColindancia', 'p')
                        ->where('p.idPredio = :idParam')
                        ->setParameter('idParam', $idpredio);

                    $predioColindancias = $qb->getQuery()->getResult();

                    foreach ($predioColindancias as $datos) {
                        $medidas[]=$datos->getMedidaMetros();
                        $descripcion[]=$datos->getDescripcion();
                    }

                    $data = [
                        'titular'          => $r->getTitular(),
                        'localidad'        => $r->getLocalidad(),
                        'titular_anterior' => $r->getTitularAnterior(),
                        // 'predio_id'        => $r->getIdContribuyente()->getIdContribuyente(),
                        'predio_id'        => $idpredio,
                        //'cve_persona'        => $r->getCvePersona(),
                        'norte'            =>  $medidas[0],
                        'sur'              =>  $medidas[1],
                        'este'             =>  $medidas[2],
                        'oeste'            =>  $medidas[3],

                        'con_norte'        =>  $descripcion[0],
                        'con_sur'          =>  $descripcion[1],
                        'con_este'         =>  $descripcion[2],
                        'con_oeste'        =>  $descripcion[3],
                    ];
                }
            } else {
                $WebService = $this->opergobserviceadapter->obtenerPredio($word);
                $data = [
                    'titular'          => $WebService->Predio->Titular,
                    'localidad'        => $WebService->Predio->NombreLocalidad,
                    'titular_anterior' => $WebService->Predio->TitularCompleto,
                    'predio_id'        => $WebService->Predio->PredioId,
                ];

                $WebService2 = $this->opergobserviceadapter->obtenerColindancia($WebService->Predio->PredioId);
                $data = [
                    'norte'            => $WebService2->PredioColindancia[0]->MedidaMts,
                    'con_norte'        => $WebService2->PredioColindancia[0]->Descripcion,

                    'sur'              => $WebService2->PredioColindancia[1]->MedidaMts,
                    'con_sur'          => $WebService2->PredioColindancia[1]->Descripcion,

                    'este'             => $WebService2->PredioColindancia[2]->MedidaMts,
                    'con_este'         => $WebService2->PredioColindancia[2]->Descripcion,

                    'oeste'            => $WebService2->PredioColindancia[3]->MedidaMts,
                    'con_oeste'        => $WebService2->PredioColindancia[3]->Descripcion,
                ];
            }

            return $response->setContent(json_encode($data));
        } else {
            echo 'Error get data from ajax';
        }
    }
}
