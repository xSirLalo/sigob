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

                    $this->bibliotecaManager->guardarArchivos($data, $categoria[$i]);
                    $predio = $this->entityManager->getRepository(Predio::class)->findOneByClaveCatastral($data['cve_catastral']);
                    if ($predio) {
                        $this->predioManager->actualizar($predio, $data);
                        $this->flashMessenger()->addSuccessMessage('Se actualizo con éxito!');
                    } else {
                        $this->predioManager->guardar($data);
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

            // if ($contribuyente > 0) {
            //     $WebService3 = $this->opergobserviceadapter->obtenerColindancia($WebService->Predio->PredioId);
            //     if (isset($WebService3->PredioColindancia)) {
            //         if (is_array($WebService3->PredioColindancia)) {
            //             foreach ($WebService3->PredioColindancia as $item) {
            //                 $WebServiceColindancia = [
            //                     'descripcion'          => $item->Descripcion,
            //                     'medida_metros'        => $item->MedidaMts,
            //                     'orientacion_geografica' => $item->OrientacionGeografica,
            //                 ];
            //             }
            //             $predio = $this->predioManager->guardarPredio($WebServicePredio);
            //             if ($predio > 0) {
            //                 $this->predioManager->guardarColindancia($predio, $WebServiceColindancia);
            //             }
            //         } else {
            //             $WebServiceColindancia = [
            //                 'descripcion'          => $WebService3->PredioColindancia->Descripcion,
            //                 'medida_metros'        => $WebService3->PredioColindancia->MedidaMts,
            //                 'orientacion_geografica' => $WebService3->PredioColindancia->OrientacionGeografica,
            //             ];
            //         }
            //     }
            // }

            $contribuyente = $this->predioManager->guardarPersona($WebServicePersona);

            if ($contribuyente) {
                $this->predioManager->guardarPredio($contribuyente, $WebServicePredio);
                // if ($predio > 0) {
                //     $this->predioManager->guardarGuardaColindancia($predio, $WebServicePredio);
                // }
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
                        'predio_id'        => $r->getIdContribuyente()->getIdContribuyente(),
                        // 'cve_persona'        => $r->getCvePersona(),
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
                    ];
                $data = [
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
