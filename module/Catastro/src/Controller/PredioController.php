<?php

declare(strict_types=1);

namespace Catastro\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Laminas\View\Model\JsonModel;
use Laminas\Paginator\Paginator;
use Laminas\Filter;
use Laminas\Validator;
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
    private $entityManager;
    private $predioManager;
    private $contribuyenteManager;
    private $bibliotecaManager;
    private $opergobserviceadapter;

    public function __construct(
        $entityManager,
        $predioManager,
        $contribuyenteManager,
        $bibliotecaManager,
        $opergobserviceadapter
    ) {
        $this->entityManager = $entityManager;
        $this->predioManager = $predioManager;
        $this->contribuyenteManager = $contribuyenteManager;
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

    public function datatableAction()
    {
        $request = $this->getRequest();
        $postData = $_POST;

        $columns = [
            0 => 'idPredio',
            1 => 'claveCatastral',
            2 => 'contribuyente',
            3 => 'ubicacion'
        ];

        if ($request->isXmlHttpRequest()) {
            $fields = ['p'];
            $qb = $this->entityManager->createQueryBuilder();
            $qb ->select($fields)->from('Catastro\Entity\Predio', 'p')
                ->innerJoin('Catastro\Entity\Contribuyente', 'c', \Doctrine\ORM\Query\Expr\Join::WITH, 'c.idContribuyente = p.idContribuyente')
                ->orderBy('c.nombre', 'ASC');
            $count = $qb->getQuery()->getScalarResult();

            $searchKeyWord = htmlspecialchars($postData['search']['value']);
            if (isset($searchKeyWord)) {
                $searchKeyWord = htmlspecialchars($postData['search']['value']);
                $qb ->where('p.claveCatastral LIKE :word')
                    ->orWhere('c.nombre LIKE :word')
                    ->orWhere('p.ubicacion LIKE :word')
                    ->setParameter("word", '%'.addcslashes($searchKeyWord, '%_').'%');
            }

            if (isset($postData['order'])) {
                $qb ->orderBy('p.'. $columns[$postData['order'][0]['column']], $postData['order'][0]['dir']);
            } else {
                $qb ->orderBy('p.idPredio', 'DESC');
            }

            if ($postData['length'] != -1) {
                $qb ->setFirstResult($postData['start'])->setMaxResults($postData['length']);
            }

            $query = $qb->getQuery()->getResult();

            $data = [];
            foreach ($query as $resultado) {
                $data[] = [
                    'idPredio' => $resultado->getIdPredio(),
                    'claveCatastral'          => $resultado->getClaveCatastral(),
                    'contribuyente' => $resultado->getIdContribuyente()->getNombre(),
                    'ubicacion' => $resultado->getUbicacion(),
                    'tipo'          => $resultado->getTipo(),
                    'opciones'        => "Cargando..."
                ];
            }

            $result = [
                    "draw"            => intval($postData['draw']),
                    "recordsTotal"    => count($count),
                    "recordsFiltered" => count($count),
                    'data'            => $data
                ];

            $json = new JsonModel($result);
            $json->setTerminal(true);
            return $json;
        } else {
            echo 'Error get data from ajax';
        }
    }

    public function addAction()
    {
        $form = new PredioForm();
        $request = $this->getRequest();
        $categorias = $this->bibliotecaManager->categorias();

        if ($request->isPost()) {
            $formData = \array_merge_recursive(
                $request->getPost()->toArray(),
                $request->getFiles()->toArray(),
            );

            $form->setData($formData);

            if ($form->isValid()) {
                $data = $form->getData();

                // exit('<pre>'.print_r($data, true).'</pre>');

                $id = $data['input1'];
                $idPredio = $this->entityManager->getRepository(Predio::class)->findOneByIdPredio($id);
                // $predio = $this->entityManager->getRepository(Predio::class)->findOneByClaveCatastral($data['cve_catastral']);
                if ($idPredio) {
                    $this->flashMessenger()->addSuccessMessage('Se actualizo con éxito!');
                    $this->predioManager->actualizarPredio($idPredio, $data);
                } else {
                    $this->flashMessenger()->addSuccessMessage('Se agrego con éxito!');
                    $predio = $this->predioManager->guardarPredio($data);
                }
                // Definimos la constante con el directorio de destino de los temporales
                define('DIR_PUBLIC', $_SERVER['DOCUMENT_ROOT']. DIRECTORY_SEPARATOR .'temporal');
                // Obtenemos el array de ficheros enviados
                $ficheros = $_FILES['archivo'];
                // Establecemos el indicador de proceso correcto (simplemente no indicando nada)
                $estado_proceso = null;
                // Paths para almacenar
                $paths= array();
                // Obtenemos los nombres de los ficheros
                $nombres_ficheros = $ficheros['name'];
                // LÍNEAS ENCARGADAS DE REALIZAR EL PROCESO DE UPLOAD POR CADA FICHERO RECIBIDO
                // ****************************************************************************

                // Si no existe la carpeta de destino la creamos
                if (!file_exists(DIR_PUBLIC)) {
                    @mkdir(DIR_PUBLIC);
                }

                if ($ficheros["error"] != 4 || $ficheros["size"] != 0) {
                    // Sólo en el caso de que exista esta carpeta realizaremos el proceso
                    if (file_exists(DIR_PUBLIC)) {
                        $archivoUrl = (array) $this->params()->fromFiles('archivo');
                        $categoria = (array) $this->params()->fromPost('id_archivo_categoria');

                        // Recorremos el array de nombres para realizar proceso de upload
                        for ($i=0; $i < count($nombres_ficheros); $i++) {
                            // Extraemos el nombre y la extensión del nombre completo del fichero
                            $nombre_extension = explode('.', basename($nombres_ficheros[$i]));
                            // Obtenemos la extensión
                            $extension=array_pop($nombre_extension);
                            // Obtenemos el nombre
                            $nombre=array_pop($nombre_extension);
                            // Creamos la ruta de destino
                            if ($nombre) {
                                if ($id == "") {
                                    $archivoUrl = $predio->getIdPredio() . '_predio_' . utf8_decode(strtolower(str_replace(" ", "-", $nombre))) . '.' . $extension;
                                    $archivo_destino = DIR_PUBLIC . DIRECTORY_SEPARATOR . $id . '_predio_' . utf8_decode(strtolower(str_replace(" ", "-", $nombre))) . '.' . $extension;
                                } else {
                                    $archivoUrl = $id . '_predio_' . utf8_decode(strtolower(str_replace(" ", "-", $nombre))) . '.' . $extension;
                                    $archivo_destino = DIR_PUBLIC . DIRECTORY_SEPARATOR . $id . '_predio_' . utf8_decode(strtolower(str_replace(" ", "-", $nombre))) . '.' . $extension;
                                }
                                // Mover el archivo de la carpeta temporal a la nueva ubicación
                                if (move_uploaded_file($ficheros['tmp_name'][$i], $archivo_destino)) {
                                    $filename = $_FILES['archivo']['name'][$i];
                                    $filesize = $_FILES['archivo']['size'][$i];
                                    $tmp_name = $_FILES['archivo']['tmp_name'][$i];
                                    $file_type = $_FILES['archivo']['type'][$i];
                                    $temp = explode(".", $filename);

                                    $data['archivoBlob'] = file_get_contents($archivo_destino, true);
                                    $data['extension'] = $temp[count($temp)-1];
                                    $data['size'] = $filesize;
                                    $data['archivoUrl'] = $archivoUrl;
                                    $data['categoria'] = $categoria[$i];

                                    $archivito = $this->bibliotecaManager->guardarArchivos($data, $categoria[$i]);
                                    if ($idPredio) {
                                        $this->bibliotecaManager->guardarRelacionAP($id, $archivito);
                                    } else {
                                        $this->bibliotecaManager->guardarRelacionAP($predio->getIdPredio(), $archivito);
                                    }
                                    // Activamos el indicador de proceso correcto
                                    $estado_proceso = true;
                                    // Almacenamos el nombre del archivo de destino
                                    $paths[] = $archivo_destino;
                                } else {
                                    // Activamos el indicador de proceso erroneo
                                    $estado_proceso = false;
                                    // Rompemos el bucle para que no continue procesando ficheros
                                    break;
                                }
                            }
                        }
                    }
                }
                return $this->redirect()->toRoute('predio');
            }
            else {
                $this->flashMessenger()->addErrorMessage($form->getMessages());
                return $this->redirect()->refresh(); # refresca esta pagina y muestra los errores
            }
        }
        return new ViewModel([
            'form' => $form,
            'categorias' => $categorias
        ]);
    }

    public function viewAction()
    {
        $predioId = (int)$this->params()->fromRoute('id', -1);
        $categorias = $this->bibliotecaManager->categoriasList();

        if ($predioId < 0) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        $predio = $this->entityManager->getRepository(Predio::class)->findOneByIdPredio($predioId);

        $qb = $this->entityManager->createQueryBuilder();
        $qb->select('p')->from('Catastro\Entity\PredioColindancia', 'p')
                ->where('p.idPredio = :idParam')
            ->setParameter('idParam', $predioId);
        $predioColindancias = $qb->getQuery()->getResult();

        $qb = $this->entityManager->createQueryBuilder();
        $qb ->select('ap')->from('Catastro\Entity\ArchivoPredio', 'ap')
                ->join('Catastro\Entity\Predio', 'p', \Doctrine\ORM\Query\Expr\Join::WITH, 'ap.idPredio = p.idPredio')
                ->join('Catastro\Entity\Archivo', 'a', \Doctrine\ORM\Query\Expr\Join::WITH, 'a.idArchivo = ap.idArchivo')
                ->join('Catastro\Entity\ArchivoCategoria', 'ac', \Doctrine\ORM\Query\Expr\Join::WITH, 'ac.idArchivoCategoria = a.idArchivoCategoria')
                ->where('ap.idPredio = :idParam')
            ->setParameter('idParam', $predioId)
            ->orderBy('ap.idArchivo', 'ASC');

        $archivos = $qb->getQuery()->getResult();

        if ($predio == null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        return new ViewModel([
            'categorias' => $categorias,
            'archivos' => $archivos,
            'predioId' => $predioId,
            'predio' => $predio,
            'colindancias' => $predioColindancias,
        ]);
    }

    public function editAction()
    {
        return new ViewModel();
    }

    public function searchCatastralAction()
    {
        $word = $_REQUEST['q'];

        $qb = $this->entityManager->createQueryBuilder();

        $qb ->select('p')->from('Catastro\Entity\Predio', 'p')
                ->where($qb->expr()->like('p.claveCatastral', ':word'))
            ->setParameter("word", '%'.addcslashes($word, '%_').'%');
        $query = $qb->getQuery()->getResult();

        $arreglo  = [];
        if ($query) {
            foreach ($query as $resultado) {
                $arreglo [] = [
                    'id' => $resultado->getClaveCatastral(),
                    'item_select_name'=> $resultado->getClaveCatastral() . '-' . $resultado->getTitular(),
                ];
            }
        } else {
            $WebService = $this->opergobserviceadapter->obtenerPredio($word);
            if (isset($WebService->Predio)) {
                if (is_array($WebService->Predio)) {
                    $WebServicePredio = [
                        'colonia'                 => $WebService->Predio[0]->NombreColonia,
                        'localidad'               => $WebService->Predio[0]->NombreLocalidad,
                        'municipio'               => $WebService->Predio[0]->NombreMunicipio,
                        'calle'                   => $WebService->Predio[0]->PredioCalle,
                        'cve_catastral'           => $WebService->Predio[0]->PredioCveCatastral,
                        'cve_predio'              => $WebService->Predio[0]->PredioId,
                        'cve_persona'             => $WebService->Predio[0]->CvePersona,
                        'numero_exterior'         => $WebService->Predio[0]->PredioNumExt,
                        'numero_interior'         => $WebService->Predio[0]->PredioNumInt,
                        'estatus'                 => $WebService->Predio[0]->PredioStatus,
                        'tipo'                    => $WebService->Predio[0]->PredioTipo,
                        'ultimo_ejercicio_pagado' => $WebService->Predio[0]->PredioUltimoEjercicioPagado,
                        'ultimo_periodo_pagado'   => $WebService->Predio[0]->PredioUltimoPeriodoPagado,
                        'titular'                 => $WebService->Predio[0]->Titular,
                        'titular_anterior'        => $WebService->Predio[0]->TitularCompleto,
                    ];
                } else {
                    $WebServicePredio = [
                        'colonia'                 => $WebService->Predio->NombreColonia,
                        'localidad'               => $WebService->Predio->NombreLocalidad,
                        'municipio'               => $WebService->Predio->NombreMunicipio,
                        'calle'                   => $WebService->Predio->PredioCalle,
                        'cve_catastral'           => $WebService->Predio->PredioCveCatastral,
                        'cve_predio'              => $WebService->Predio->PredioId,
                        'cve_persona'             => $WebService->Predio->CvePersona,
                        'numero_exterior'         => $WebService->Predio->PredioNumExt,
                        'numero_interior'         => $WebService->Predio->PredioNumInt,
                        'estatus'                 => $WebService->Predio->PredioStatus,
                        'tipo'                    => $WebService->Predio->PredioTipo,
                        'ultimo_ejercicio_pagado' => $WebService->Predio->PredioUltimoEjercicioPagado,
                        'ultimo_periodo_pagado'   => $WebService->Predio->PredioUltimoPeriodoPagado,
                        'titular'                 => $WebService->Predio->Titular,
                        'titular_anterior'        => $WebService->Predio->TitularCompleto,
                    ];
                }

                $WebService2 = $this->opergobserviceadapter->obtenerPersonaPorCve($WebServicePredio['cve_persona']);

                if (isset($WebService2->Persona)) {
                    if (is_array($WebService2->Persona)) {
                        $WebServicePersona = [
                                'cve_persona'      => $WebService2->Persona[0]->CvePersona,
                                'nombre'           => $WebService2->Persona[0]->NombrePersona,
                                'apellido_paterno' => $WebService2->Persona[0]->ApellidoPaternoPersona,
                                'apellido_materno' => $WebService2->Persona[0]->ApellidoMaternoPersona,
                                'tipo_persona'     => $WebService2->Persona[0]->TipoPersona,
                                'rfc'              => $WebService2->Persona[0]->RFCPersona,
                                'curp'             => $WebService2->Persona[0]->CURPPersona,
                                'razon_social'     => $WebService2->Persona[0]->RazonSocialPersona,
                                'correo'           => $WebService2->Persona[0]->PersonaCorreo,
                                'telefono'         => $WebService2->Persona[0]->PersonaTelefono,
                                'genero'           => $WebService2->Persona[0]->GeneroPersona,
                        ];
                    } else {
                        if (isset($WebService2->Persona)) {
                            $WebServicePersona = [
                                'cve_persona'      => $WebService2->Persona->CvePersona,
                                'nombre'           => $WebService2->Persona->NombrePersona,
                                'apellido_paterno' => $WebService2->Persona->ApellidoPaternoPersona,
                                'apellido_materno' => $WebService2->Persona->ApellidoMaternoPersona,
                                'tipo_persona'     => $WebService2->Persona->TipoPersona,
                                'rfc'              => $WebService2->Persona->RFCPersona,
                                'curp'             => $WebService2->Persona->CURPPersona,
                                'razon_social'     => $WebService2->Persona->RazonSocialPersona,
                                'correo'           => $WebService2->Persona->PersonaCorreo,
                                'telefono'         => $WebService2->Persona->PersonaTelefono,
                                'genero'           => $WebService2->Persona->GeneroPersona,
                            ];
                        }
                    }
                    $contribuyente = $this->contribuyenteManager->guardarPersona($WebServicePersona);
                }

                if ($contribuyente) {
                    $predio = $this->predioManager->guardarPredio($contribuyente, $WebServicePredio);

                    $WebService3 = $this->opergobserviceadapter->obtenerColindancia($predio->getCvePredio());

                    // FIXME: Cambiaron los nombre de la tabla Colindancia no deja guardar colindancias.

                    // if (isset($WebService3->PredioColindancia)) {
                        // if (is_array($WebService3->PredioColindancia)) {
                            // foreach ($WebService3->PredioColindancia as $item) {
                            //     $WebServiceColindancia = [
                            //         'medida_metros'            => $item->MedidaMts,
                            //         'descripcion'              => $item->Descripcion,
                            //         'orientacion_geografica'   => $item->OrientacionGeografica,
                            //     ];
                            // }
                        // } else {
                        //     $WebServiceColindancia = [
                        //         'medida_metros'            => $WebService3->PredioColindancia->MedidaMts,
                        //         'descripcion'              => $WebService3->PredioColindancia->Descripcion,
                        //         'orientacion_geografica'   => $WebService3->PredioColindancia->OrientacionGeografica,
                        //     ];
                        // }
                        // $this->predioManager->guardarColindancia($predio, $WebServiceColindancia);
                    // }
                }

                // foreach ($WebService3->PredioColindancia as $item) {
                //     $WebServiceColindancia = [
                //         'medida_metros'            => $item->MedidaMts,
                //         'descripcion'              => $item->Descripcion,
                //         'orientacion_geografica'   => $item->OrientacionGeografica,
                //     ];
                //     if ($predio) {
                        // $this->predioManager->guardarColindancia($predio, $WebServiceColindancia);
                //     }
                // }

                $arreglo[] = [
                    'id' => $WebServicePredio['cve_catastral'],
                    'item_select_name' => $WebServicePredio['cve_catastral'] . '-' . $WebServicePredio['titular'],
                ];
            } // if isset($WebService->Predio)
        } // else $query

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
        $word = $this->params()->fromRoute('id');

        if ($request->isXmlHttpRequest()) {
            $qb = $this->entityManager->createQueryBuilder();
            $qb ->select('p')->from('Catastro\Entity\Predio', 'p')
                    ->where($qb->expr()->like('p.claveCatastral', ':word'))
                ->setParameter("word", '%'.addcslashes($word, '%_').'%');
            $query = $qb->getQuery()->getResult();
            $data = [];
            if ($query) {
                foreach ($query as $resultado) {
                    $idpredio = $resultado->getIdPredio();

                    // $qb = $this->entityManager->createQueryBuilder();
                    // $qb ->select('p')->from('Catastro\Entity\PredioColindancia', 'p')
                    //         ->where('p.idPredio = :idParam')
                    //     ->setParameter('idParam', $idpredio);

                    // $predioColindancias = $qb->getQuery()->getResult();

                    // foreach ($predioColindancias as $datos) {
                    //     $medidas[]=$datos->getMedidaMetros();
                    //     $descripcion[]=$datos->getDescripcion();
                    // }

                    $data = [
                        'titular'          => $resultado->getTitular(),
                        'localidad'        => $resultado->getLocalidad(),
                        'colonia'        => $resultado->getColonia(),
                        'municipio'        => $resultado->getMunicipio(),
                        'calle'        => $resultado->getCalle(),
                        'numero_interior'        => $resultado->getNumeroInterior(),
                        'numero_exterior'        => $resultado->getNumeroExterior(),
                        'tipo'        => $resultado->getTipo(),
                        'ultimo_ejercicio_pagado'        => $resultado->getUltimoEjercicioPagado(),
                        'ultimo_periodo_pagado'        => $resultado->getUltimoPeriodoPagado(),
                        'titular_anterior' => $resultado->getTitularAnterior(),
                        'contribuyente_id'        => $resultado->getIdContribuyente()->getIdContribuyente(),
                        'predio_id'        => $idpredio,
                        //'cve_persona'        => $resultado->getCvePersona(),
                        // 'norte'            =>  $medidas[0],
                        // 'sur'              =>  $medidas[1],
                        // 'este'             =>  $medidas[2],
                        // 'oeste'            =>  $medidas[3],

                        // 'con_norte'        =>  $descripcion[0],
                        // 'con_sur'          =>  $descripcion[1],
                        // 'con_este'         =>  $descripcion[2],
                        // 'con_oeste'        =>  $descripcion[3],
                    ];
                }
            } else {
                $WebService = $this->opergobserviceadapter->obtenerPredio($word);
                $data = [
                    'localidad'        => $WebService->Predio->NombreLocalidad,
                ];

                // $WebService2 = $this->opergobserviceadapter->obtenerColindancia($WebService->Predio->PredioId);
                // $data = [
                //     'norte'            => $WebService2->PredioColindancia[0]->MedidaMts,
                //     'con_norte'        => $WebService2->PredioColindancia[0]->Descripcion,

                //     'sur'              => $WebService2->PredioColindancia[1]->MedidaMts,
                //     'con_sur'          => $WebService2->PredioColindancia[1]->Descripcion,

                //     'este'             => $WebService2->PredioColindancia[2]->MedidaMts,
                //     'con_este'         => $WebService2->PredioColindancia[2]->Descripcion,

                //     'oeste'            => $WebService2->PredioColindancia[3]->MedidaMts,
                //     'con_oeste'        => $WebService2->PredioColindancia[3]->Descripcion,
                // ];
            }
            $json = new JsonModel($data);
            $json->setTerminal(true);

            return $json;
        } else {
            echo 'Error get data from ajax';
        }
    }
}
