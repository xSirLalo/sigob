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
use Catastro\Entity\Contribuyente;
use Catastro\Form\ContribuyenteForm;
use Catastro\Form\ContribuyenteModalForm;
use Catastro\Form\EliminarForm;
use Catastro\Form\BibliotecaForm;

class ContribuyenteController extends AbstractActionController
{
    /**
     * Entity manager.
     * @var Doctrine\ORM\EntityManager
     */
    private $entityManager;
    /**
     * Contribuyente Manager.
     * @var Catastro\Service\ContribuyenteManager
     */
    private $contribuyenteManager;
    private $bibliotecaManager;
    private $opergobserviceadapter;

    public function __construct($entityManager, $contribuyenteManager, $bibliotecaManager, $opergobserviceadapter)
    {
        $this->entityManager = $entityManager;
        $this->contribuyenteManager = $contribuyenteManager;
        $this->bibliotecaManager = $bibliotecaManager;
        $this->opergobserviceadapter = $opergobserviceadapter;
    }

    public function indexAction()
    {
        $page = $this->params()->fromQuery('page', 1);
        $query = $this->entityManager->getRepository(Contribuyente::class)->createQueryBuilder('c')->getQuery();

        $adapter = new DoctrineAdapter(new ORMPaginator($query, false));
        $paginator = new Paginator($adapter);
        $paginator->setDefaultItemCountPerPage(10);
        $paginator->setCurrentPageNumber($page);

        return new ViewModel(['contribuyentes' => $paginator]);
    }

    public function datatableAction()
    {
        $request = $this->getRequest();
        $response = $this->getResponse();
        $postData = $_POST;

        $columns = [
            0 => 'idContribuyente',
            1 => 'nombre',
            2 => 'rfc',
            3 => 'curp'
        ];
        // AJAX response
        if ($request->isXmlHttpRequest()) {
            $fields = ['c'];
            $qb = $this->entityManager->createQueryBuilder();
            $qb ->select($fields)->from('Catastro\Entity\Contribuyente', 'c');
            $count = $qb->getQuery()->getScalarResult();

            $searchKeyWord = htmlspecialchars($postData['search']['value']);
            if (isset($searchKeyWord)) {
                $searchKeyWord = htmlspecialchars($postData['search']['value']);
                $qb ->where('c.nombre LIKE :word')
                    ->orWhere('c.rfc LIKE :word')
                    ->orWhere('c.curp LIKE :word')
                    ->setParameter("word", '%'.addcslashes($searchKeyWord, '%_').'%');
            }

            if (isset($postData['order'])) {
                $qb ->orderBy('c.'. $columns[$postData['order'][0]['column']], $postData['order'][0]['dir']);
            } else {
                $qb ->orderBy('c.idContribuyente', 'DESC');
            }

            if ($postData['length'] != -1) {
                $qb ->setFirstResult($postData['start'])->setMaxResults($postData['length']);
            }

            $query = $qb->getQuery()->getResult();

            $data = [];
            foreach ($query as $r) {
                $data[] = [
                    'idContribuyente' => $r->getIdContribuyente(),
                    'nombre'          => $r->getNombre(),
                    'rfc' => $r->getRfc(),
                    'curp' => $r->getCurp(),
                    'tipoPersona'          => $r->getTipoPersona(),
                    'opciones'        => "Cargando..."
                ];
            }

            $result = [
                    "draw"            => intval($postData['draw']),
                    "recordsTotal"    => count($count),
                    "recordsFiltered" => count($count),
                    'data'            => $data
                ];

            // return $response->setContent(json_encode($result));

            // $response->setStatusCode(200);
            // $response->setContent(\Laminas\Json\Json::encode($result));
            // return $response;

            $json = new JsonModel($result);
            $json->setTerminal(true);
            return $json;
        } else {
            echo 'Error get data from ajax';
        }
    }

    public function addAction()
    {
        $form = new ContribuyenteForm();
        $request = $this->getRequest();
        $categorias = $this->bibliotecaManager->categorias();

        if ($request->isPost()) {
            $formData = array_merge_recursive(
                $request->getPost()->toArray(),
                $request->getFiles()->toArray()
            );

            // $formData = $request->getPost()->toArray();
            // $inputFilter = new OptionalInputFilter();
            // $inputFilter->add([
            //     'name' => 'rfc',
            //     'required' => true,
            //     'filters' => [
            //         ['name' => Filter\StripTags::class],
            //         ['name' => Filter\StringTrim::class],
            //     ],
            //     'validators' => [
            //         ['name' => Validator\NotEmpty::class],
            //         // ['name' => Validator\EmailAddress::class],
            //             [
            //                 'name' => '\DoctrineModule\Validator\NoObjectExists',
            //                 'options' => array(
            //                     'object_repository' => $this->entityManager->getRepository(Contribuyente::class),
            //                     'fields' => array('rfc'),
            //                     'messages' => array(
            //                         'objectFound' => 'Este R.F.C ya se encuentra registrado.'
            //                         ),
            //                 ),
            //             ],                        [
            //                 'name' => '\DoctrineModule\Validator\NoObjectExists',
            //                 'options' => array(
            //                     'object_repository' => $this->entityManager->getRepository(Contribuyente::class),
            //                     'fields' => array('curp'),
            //                     'messages' => array(
            //                         'objectFound' => 'Este C.U.R.P ya se encuentra registrado.'
            //                         ),
            //                 ),
            //             ],
            //     ],
            // ]);
            // $form->setInputFilter($inputFilter);
            
            $form->setData($formData);
            $form->setValidationGroup(['tipo_persona']);

            if ($form->isValid()) {
                $data = $form->getData();
                $tipoPersona = $data['tipo_persona'];

                if ($tipoPersona=='F') { // Persona Física
                    $form->setValidationGroup([
                        'input1', // ID Contribuyente
                        'tipo_persona',
                        'nombre',
                        'apellido_paterno',
                        'apellido_materno',
                        'fecha_nacimiento',
                        'estado_civil',
                        'genero',
                        'rfc',
                        'curp',
                        'correo',
                        'telefono',
                        'id_archivo_categoria',
                        'archivo',
                    ]);
                } elseif ($tipoPersona=='M') { // Persona Moral
                    $form->setValidationGroup([
                        'input1', // ID Contribuyente
                        'tipo_persona',
                        'nombre',
                        'razon_social',
                        'rfc',
                        'correo',
                        'telefono',
                        'id_archivo_categoria',
                        'archivo',
                    ]);
                }
                if ($form->isValid()) {
                    try {
                        $data = $form->getData();

                        // exit('<pre>'.print_r($data, true).'</pre>');

                        $id = $data['input1'];
                        $contribuyente = $this->entityManager->getRepository(Contribuyente::class)->findOneByIdContribuyente($id);
                        // Definimos la constante con el directorio de destino de los temporales
                        define('DIR_PUBLIC', $_SERVER['DOCUMENT_ROOT']. DIRECTORY_SEPARATOR .'temporal');
                        // Obtenemos el array de ficheros enviados
                        $ficheros = $_FILES['archivo'];
                        // Establecemos el indicador de proceso correcto (simplemente no indicando nada)
                        $estado_proceso = NULL;
                        // Paths para almacenar
                        $paths= array();
                        // Obtenemos los nombres de los ficheros
                        $nombres_ficheros = $ficheros['name'];
                        // LÍNEAS ENCARGADAS DE REALIZAR EL PROCESO DE UPLOAD POR CADA FICHERO RECIBIDO
                        // ****************************************************************************

                        // Si no existe la carpeta de destino la creamos
                        if(!file_exists(DIR_PUBLIC)) @mkdir(DIR_PUBLIC);    

                        if ($ficheros["error"] != 4 || $ficheros["size"] != 0)
                        {
                            // Sólo en el caso de que exista esta carpeta realizaremos el proceso
                            if(file_exists(DIR_PUBLIC)) {

                                $archivoUrl = (array) $this->params()->fromFiles('archivo');
                                $categoria = (array) $this->params()->fromPost('id_archivo_categoria');

                                // Recorremos el array de nombres para realizar proceso de upload
                                for($i=0; $i < count($nombres_ficheros); $i++){
                                    // Extraemos el nombre y la extensión del nombre completo del fichero
                                    $nombre_extension = explode('.', basename($nombres_ficheros[$i]));
                                    // Obtenemos la extensión
                                    $extension=array_pop($nombre_extension);
                                    // Obtenemos el nombre
                                    $nombre=array_pop($nombre_extension);
                                    // Creamos la ruta de destino
                                    if ($nombre) {
                                        $archivo_destino = DIR_PUBLIC . DIRECTORY_SEPARATOR . $id . '_' . utf8_decode(strtolower(str_replace(" ", "-",$nombre))) . '.' . $extension;
                                        // Mover el archivo de la carpeta temporal a la nueva ubicación
                                        if(move_uploaded_file($ficheros['tmp_name'][$i], $archivo_destino)) {
                                            $filename = $_FILES['archivo']['name'][$i];
                                            $filesize = $_FILES['archivo']['size'][$i];
                                            $tmp_name = $_FILES['archivo']['tmp_name'][$i];
                                            $file_type = $_FILES['archivo']['type'][$i];
                                            $temp = explode(".", $filename);

                                            $data['archivoBlob'] = file_get_contents($archivo_destino, true);
                                            $data['extension'] = $temp[count($temp)-1];
                                            $data['size'] = $filesize;
                                            $data['archivoUrl'] = $id . '_' . strtolower(str_replace(" ", "-", $archivoUrl[$i]['name']));
                                            $data['categoria'] = $categoria[$i];

                                            $archivito = $this->bibliotecaManager->guardarArchivos($data, $categoria[$i]);
                                            if ($contribuyente) {
                                                $this->bibliotecaManager->guardarRelacionAC($id, $archivito);
                                            } else {
                                                $this->bibliotecaManager->guardarRelacionAC($contribuyente, $archivito);
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
                        if ($contribuyente) {
                            $this->contribuyenteManager->actualizarContribuyente($contribuyente, $data);
                            $this->flashMessenger()->addInfoMessage('Se actualizo con éxito!');
                        } else {
                            $contribuyente = $this->contribuyenteManager->guardarContribuyente($data);
                            $this->flashMessenger()->addSuccessMessage('Se agrego con éxito!');
                        }
                        return $this->redirect()->toRoute('contribuyente');
                        
                    } catch (RuntimeException $exception) {
                        $this->flashMessenger()->addErrorMessage($exception->getMessage());
                        return $this->redirect()->refresh(); # refresca esta pagina y muestra los errores
                    }
                }   else {
                    $this->flashMessenger()->addErrorMessage($form->getMessages());
                        return $this->redirect()->refresh(); # refresca esta pagina y muestra los errores
                }
            }else {
                    $this->flashMessenger()->addErrorMessage($form->getMessages());
                        return $this->redirect()->refresh(); # refresca esta pagina y muestra los errores
                }
        }
        return new ViewModel(['form' => $form, 'categorias' => $categorias]);
    }

    public function viewAction()
    {
        $contribuyenteId = (int)$this->params()->fromRoute('id', -1);
        $categorias = $this->bibliotecaManager->categoriasList();


        if ($contribuyenteId < 0) {
            $this->layout()->setTemplate('error/404');
            $this->getResponse()->setStatusCode(404);
            return $response->setTemplate('error/404');
        }

        $contribuyente = $this->entityManager->getRepository(Contribuyente::class)->findOneByIdContribuyente($contribuyenteId);

        $qb = $this->entityManager->createQueryBuilder();
        $qb ->select('aco')
            ->from('Catastro\Entity\ArchivoContribuyente', 'aco')
            ->join('Catastro\Entity\Contribuyente', 'c', \Doctrine\ORM\Query\Expr\Join::WITH, 'aco.idContribuyente = c.idContribuyente')
            ->join('Catastro\Entity\Archivo', 'a', \Doctrine\ORM\Query\Expr\Join::WITH, 'a.idArchivo = aco.idArchivo')
            ->join('Catastro\Entity\ArchivoCategoria', 'ac', \Doctrine\ORM\Query\Expr\Join::WITH, 'ac.idArchivoCategoria = a.idArchivoCategoria')
            ->where('aco.idContribuyente = :idParam')
            ->setParameter('idParam', $contribuyenteId)
            ->orderBy('aco.idArchivo', 'ASC');

        $archivos = $qb->getQuery()->getResult();

        if ($contribuyente == null) {
            $this->layout()->setTemplate('error/404');
            $this->getResponse()->setStatusCode(404);
            return $response->setTemplate('error/404');
        }

        $data['contribuyente'] =  $contribuyente;
        $data['archivos'] =  $archivos;
        $data['contribuyenteId'] =  $contribuyenteId;
        $data['categorias'] =  $categorias;

        return new ViewModel($data);
    }

    public function editAction()
    {
        $form = new ContribuyenteForm();
        $request = $this->getRequest();
        $response = $this->getResponse();
        $contribuyenteId = (int)$this->params()->fromRoute('id', -1);

        if ($contribuyenteId < 0) {
            $this->layout()->setTemplate('error/404');
            $this->getResponse()->setStatusCode(404);
            return $response->setTemplate('error/404');
        }

        $contribuyente = $this->entityManager->getRepository(Contribuyente::class)->findOneByIdContribuyente($contribuyenteId);

        if ($contribuyente == null) {
            $this->layout()->setTemplate('error/404');
            $this->getResponse()->setStatusCode(404);
            return $response->setTemplate('error/404');
        }

        if ($this->getRequest()->isPost()) {
            $formData = $this->params()->fromPost();
            $form->setData($formData);
            $form->setValidationGroup(['tipo_persona']);
            if ($form->isValid()) {
                $data = $form->getData();
                $tipoPersona = $data['tipo_persona'];

                if ($tipoPersona=='F') { // Persona Física
                    $form->setValidationGroup([
                        'input1', // ID Contribuyente
                        'tipo_persona',
                        'nombre',
                        'apellido_paterno',
                        'apellido_materno',
                        'fecha_nacimiento',
                        'estado_civil',
                        'genero',
                        'rfc',
                        'curp',
                        'correo',
                        'telefono',
                    ]);
                    $fecha_nacimiento = $formData['year'].'-'.$formData['month'].'-'.$formData['day'];
                } elseif ($tipoPersona=='M') { // Persona Moral
                    $form->setValidationGroup([
                        'input1', // ID Contribuyente
                        'tipo_persona',
                        'nombre',
                        'razon_social',
                        'rfc',
                        'correo',
                        'telefono',
                    ]);
                    $fecha_nacimiento = null;
                }
                if ($form->isValid()) {
                try {
                        $data = $form->getData();
                        $data['fecha_nacimiento'] = $fecha_nacimiento;

                        $this->contribuyenteManager->actualizarContribuyente($contribuyente, $data);
                        $this->flashMessenger()->addInfoMessage('Se actualizo con éxito');
                        return $this->redirect()->toRoute('contribuyente');
                    } catch (RuntimeException $exception) {
                        $this->flashMessenger()->addErrorMessage($exception->getMessage());
                        return $this->redirect()->refresh(); # refresca esta pagina y muestra los errores
                    }
                }
            }
        } else {
            $data = [
                'tipo_persona' => $contribuyente->getTipoPersona(),
                'nombre' => $contribuyente->getNombre(),
                'apellido_paterno' => $contribuyente->getApellidoPaterno(),
                'apellido_materno' => $contribuyente->getApellidoMaterno(),
                'estado_civil' => $contribuyente->getEstadoCivil(),
                'fecha_nacimiento' => $contribuyente->getFechaNacimiento(),
                'razon_social' => $contribuyente->getRazonSocial(),
                'rfc' => $contribuyente->getRfc(),
                'curp' => $contribuyente->getCurp(),
                'genero' => $contribuyente->getGenero(),
                'correo' => $contribuyente->getCorreo(),
                'telefono' => $contribuyente->getTelefono(),
            ];
            $form->setData($data);
        }
        return new ViewModel(['form' => $form]);
    }

    public function deleteAction()
    {
        $form = new EliminarForm();
        $request = $this->getRequest();
        $contribuyenteId = (int)$this->params()->fromRoute('id', -1);

        if ($request->isXmlHttpRequest()) {
            $contribuyente = $this->entityManager->getRepository(Contribuyente::class)->findOneByIdContribuyente($contribuyenteId);
            $this->contribuyenteManager->eliminar($contribuyente);

            $this->flashMessenger()->addSuccessMessage('Se elimino con éxito');
            $view = new JsonModel();
            $view->setTerminal(true);
        } else {
            if ($contribuyenteId < 0) {
                $this->layout()->setTemplate('error/404');
                $this->getResponse()->setStatusCode(404);
                return $response->setTemplate('error/404');
            }

            $contribuyente = $this->entityManager->getRepository(Contribuyente::class)->findOneByIdContribuyente($contribuyenteId);

            // if ($contribuyente == null) {
            //     $this->layout()->setTemplate('error/404');
            //     $this->getResponse()->setStatusCode(404);
            //     return $response->setTemplate('error/404');
            // }

            if ($this->getRequest()->isPost()) {
                $data = $this->params()->fromPost();
                $form->setData($data);
                if ($form->isValid()) {
                    if ($this->getRequest()->getPost()->get('delete') == 'Yes') {
                        $this->flashMessenger()->addSuccessMessage('Se elimino con éxito!');
                        $this->contribuyenteManager->eliminar($contribuyente);
                    }
                    return $this->redirect()->toRoute('contribuyente');
                }
            }
            $view = new ViewModel(['form' => $form, 'id' => $contribuyenteId]);
        }
        return $view;
    }

    public function searchPersonaAction()
    {
        $word = $_REQUEST['q'];

        $qb = $this->entityManager->createQueryBuilder();

        $qb ->select('c')->from('Catastro\Entity\Contribuyente', 'c')
                ->where($qb->expr()->like('c.nombre', ":word"))
                ->orWhere($qb->expr()->like('c.apellidoPaterno', ":word"))
                ->orWhere($qb->expr()->like('c.apellidoMaterno', ":word"))
                ->orWhere($qb->expr()->like('c.rfc', ":word"))
                ->orWhere($qb->expr()->like('c.cvePersona', ":word"))
            ->setParameter("word", '%'.addcslashes($word, '%_').'%');
        $query = $qb->getQuery()->getResult();

        $arreglo  = [];
        if ($query) {
            foreach ($query as $r) {
                $arreglo [] = [
                    'id' => $r->getIdContribuyente(),
                    'item_select_name'=> $r->getCvePersona().'-'.$r->getNombre(). ' ' .$r->getApellidoPaterno(). ' ' .$r->getApellidoMaterno(),
                ];
            }
        } else {
            $WebService = $this->opergobserviceadapter->obtenerNombrePersona($word);
            if (empty($WebService->Persona)) {
                $WebService = $this->opergobserviceadapter->obtenerPersonaPorCve($word);
            }
            if (isset($WebService->Persona)) {
                if (is_array($WebService->Persona)) {
                    $WebServicePersona = [
                            'cve_persona'      => $WebService->Persona[0]->CvePersona,
                            'nombre'           => $WebService->Persona[0]->NombrePersona,
                            'apellido_paterno' => $WebService->Persona[0]->ApellidoPaternoPersona,
                            'apellido_materno' => $WebService->Persona[0]->ApellidoPaternoPersona,
                            'tipo_persona'     => $WebService->Persona[0]->TipoPersona,
                            'rfc'              => $WebService->Persona[0]->RFCPersona,
                            'curp'             => $WebService->Persona[0]->CURPPersona,
                            'razon_social'     => $WebService->Persona[0]->RazonSocialPersona,
                            'correo'           => $WebService->Persona[0]->PersonaCorreo,
                            'telefono'         => $WebService->Persona[0]->PersonaTelefono,
                            'genero'           => $WebService->Persona[0]->GeneroPersona,
                    ];

                    $contribuyente = $this->contribuyenteManager->guardarPersona($WebServicePersona);

                    if ($contribuyente) {
                        $arreglo[] = [
                                    'id' => $contribuyente->getIdContribuyente(),
                                    'item_select_name' => $WebService->Persona[0]->CvePersona.' '.$WebService->Persona[0]->NombrePersona,
                                ];
                    }
                } else {
                    if (isset($WebService->Persona)) {
                        $WebServicePersona = [
                            'cve_persona'      => $WebService->Persona->CvePersona,
                            'nombre'           => $WebService->Persona->NombrePersona,
                            'apellido_paterno' => $WebService->Persona->ApellidoPaternoPersona,
                            'apellido_materno' => $WebService->Persona->ApellidoPaternoPersona,
                            'rfc'              => $WebService->Persona->RFCPersona,
                            'curp'             => $WebService->Persona->CURPPersona,
                            'razon_social'     => $WebService->Persona->RazonSocialPersona,
                            'correo'           => $WebService->Persona->PersonaCorreo,
                            'telefono'         => $WebService->Persona->PersonaTelefono,
                            'genero'           => $WebService->Persona->GeneroPersona,
                    ];

                        $contribuyente = $this->contribuyenteManager->guardarPersona($WebServicePersona);

                        if ($contribuyente) {
                            $arreglo[] = [
                                'id' => $contribuyente->getIdContribuyente(),
                                'item_select_name' => $WebService->Persona->CvePersona.' '.$WebService->Persona->NombrePersona,
                            ];
                        }
                    }
                }
            }
        }

        $data = [
            'items'       => $arreglo,
            'total_count' => count($arreglo),
        ];

        $json = new JsonModel($data);
        $json->setTerminal(true);

        return $json;
    }

    public function autofillPersonaAction()
    {
        $request = $this->getRequest();
        $response = $this->getResponse();
        // AJAX response
        if ($request->isXmlHttpRequest()) {
            $id = $this->params()->fromRoute('id');

            $qb = $this->entityManager->createQueryBuilder();

            $qb ->select('c')
                ->from('Catastro\Entity\Contribuyente', 'c')
                ->where('c.idContribuyente = :idParam')
                ->setParameter("idParam", $id);
            $query = $qb->getQuery()->getResult();

            $data = [];
            if ($query) {
                foreach ($query as $r) {
                    $data = [
                        'contribuyente_id' => $r->getIdContribuyente(),
                        'nombre'           => $r->getNombre(),
                        'apellido_paterno' => $r->getApellidoPaterno(),
                        'apellido_materno' => $r->getApellidoMaterno(),
                        'fecha_nacimiento' => $r->getFechaNacimiento(),
                        'estado_civil'     => $r->getEstadoCivil(),
                        'genero'           => $r->getGenero(),
                        'tipo_persona'     => $r->getTipoPersona(),
                        'rfc'              => $r->getRfc(),
                        'curp'             => $r->getCurp(),
                        'razon_social'     => $r->getRazonSocial(),
                        'correo'           => $r->getCorreo(),
                        'telefono'         => $r->getTelefono(),
                    ];
                }
            } else {
                // FIXME: No pasa por aquí!
                $WebService = $this->opergobserviceadapter->obtenerPersonaPorRfc($id);

                $data = [
                    'nombre'           => $WebService->Persona->NombrePersona,
                    'apellido_paterno' => $WebService->Persona->ApellidoPaternoPersona,
                    'apellido_materno' => $WebService->Persona->ApellidoMaternoPersona,
                    'tipo_persona'     => $WebService->Persona->TipoPersona,
                    'rfc'              => $WebService->Persona->RFCPersona,
                    'curp'             => $WebService->Persona->CURPPersona,
                    'razon_social'     => $WebService->Persona->RazonSocialPersona,
                    'correo'           => $WebService->Persona->PersonaCorreo,
                    'telefono'         => $WebService->Persona->PersonaTelefono,
                    'genero'           => $WebService->Persona->GeneroPersona,
                ];
            }

            return $response->setContent(json_encode($data));
        } else {
            echo 'Error get data from ajax';
        }
    }

    public function pdfAction()
    {
        $pdf = new \TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('SIGOB');
        $pdf->SetTitle('Listado');
        $pdf->SetSubject('Listado');
        $pdf->SetKeywords('TCPDF, PDF');

        $PDF_HEADER_LOGO = "./public/logo.jpg";
        $PDF_HEADER_LOGO_WIDTH = 14;
        $PDF_HEADER_TITLE = "Sistemas de Gobierno.";
        $PDF_HEADER_STRING = "Lista de Contribuyentes \nGenerado con fecha: " . date('d-m-Y');

        // set default header data
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' del '.date('d-m-Y'), PDF_HEADER_STRING);

        // set header and footer fonts
        $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__) . '/lang/spa.php')) {
            require_once(dirname(__FILE__) . '/lang/spa.php');
            $pdf->setLanguageArray($l);
        }

        // ---------------------------------------------------------

        // Set font
        // dejavusans is a UTF-8 Unicode font, if you only need to
        // print standard ASCII chars, you can use core fonts like
        // helvetica or times to reduce file size.
        $pdf->SetFont('helvetica', 'B', 20);

        // Add a page
        // This method has several options, check the source code documentation for more information.
        $pdf->AddPage();

        $pdf->Write(20, 'Listado de Computadoras', '', 0, 'C', true, 0, false, false, 0);

        $pdf->SetFont('helvetica', '', 10);

        // -----------------------------------------------------------------------------

        $tbl = '<table  cellspacing="0" cellpadding="1" border="1" style="border-color:gray; width:100%;">';
        $tbl .= '<tr style="background-color:#47A7AC;color:black;">
                    <th>Nombre</th>
                    <th>Apellido Paterno</th>
                    <th>Apellido Materno</th>
                    <th>R.F.C.</th>
                    <th>C.U.R.P</th>
                </tr>';
        // foreach item in your array...
        // $computadorasInfo = $this->Computadora_model->getRows();
        $contribuyentes = $this->entityManager->getRepository(Contribuyente::class)->createQueryBuilder('c')->getQuery()->getResult();
        foreach ($contribuyentes as $contribuyente) :
        $tbl .=   '<tr>
                    <td>' . $contribuyente->getNombre() . '</td>
                    <td>' . $contribuyente->getApellidoPaterno() . '</td>
                    <td>' . $contribuyente->getApellidoMaterno() . '</td>
                    <td>' . $contribuyente->getRfc() . '</td>
                    <td>' . $contribuyente->getCurp() . '</td>
                </tr>';
        endforeach;
        $tbl = $tbl . '</table>';

        $pdf->writeHTML($tbl, true, 0, true, 0, 'C');

        // move pointer to last page
        $pdf->lastPage();

        // ---------------------------------------------------------

        // Close and output PDF document
        if (ob_get_contents()) {
            ob_end_clean();
        }

        // This method has several options, check the source code documentation for more information.
        $pdf->Output('listadoPdf_' . date('dmY') . '.pdf', 'D');
        //============================================================+
        // END OF FILE
        //============================================================+
    }

    public function excelAction()
    {
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        //Set sheet meta data
        $spreadsheet->getProperties()
                    ->setCreator("Eduardo Cauich Herrera")
                    ->setLastModifiedBy("Contribuyentes")
                    ->setTitle("Lista Contribuyentes")
                    ->setSubject("Estos son datos de Contribuyente exportados desde SIGOB")
                    ->setDescription(
                        "Sistema de Gobierno"
                    )
                    ->setKeywords("datos")
                    ->setCategory("contribuyentes");
        // Set title
        $styleArray = [
            'font' => [
                'bold' => true,
                'size' => 18,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
                'rotation' => 90,
                'startColor' => [
                    'rgb' => '47A7AC',
                ],
                'endColor' => [
                    'rgb' => 'FFFFFF',
                ],
            ],
        ];
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Contribuyentes')
            ->mergeCells("A1:F1")
            ->getStyle('A1:F1')->applyFromArray($styleArray);

        //Set tittle columns
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A2', 'ID')
            ->setCellValue('B2', 'Nombre')
            ->setCellValue('C2', 'Apellido Paterno')
            ->setCellValue('D2', 'Apellido Materno')
            ->setCellValue('E2', 'R.F.C.')
            ->setCellValue('F2', 'C.U.R.P')
            ->setTitle('Libro Contribuyente');
        //Get data
        $contribuyentes = $this->entityManager->getRepository(Contribuyente::class)->createQueryBuilder('c')->getQuery()->getResult();

        $rows = 3;
        $dataCount = 2;
        foreach ($contribuyentes as $contribuyente):
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $rows, $contribuyente->getIdContribuyente())
                ->setCellValue('B' . $rows, $contribuyente->getNombre())
                ->setCellValue('C' . $rows, $contribuyente->getApellidoPaterno())
                ->setCellValue('D' . $rows, $contribuyente->getApellidoMaterno())
                ->setCellValueExplicit('E' . $rows, $contribuyente->getRfc(), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('F' . $rows, $contribuyente->getCurp(), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $rows++;
        $dataCount++;

        $sheet = $spreadsheet->getActiveSheet();

        //Set column width to auto
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);

        //Set table outer borders
        $styleArray = [
                'font' => [
                    'bold' => false,
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                ],
                'borders' => [
                    'top' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                    'right' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                    'bottom' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                    'left' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ],
            ];
        //Get number of rows
        $sheet->getStyle('A2:F' . $dataCount . '')->applyFromArray($styleArray);
        endforeach;
        //Set header outer borders
        $styleArray = [
            'font' => [
                'bold' => true,
                'size' => 12,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
            ],
            'borders' => [
                'top' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
                'right' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
                'bottom' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
                'left' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];

        $sheet->getStyle('A2:F2')->applyFromArray($styleArray);

        // File name
        $filename = 'listadoExcel_' . date('dmY');

        // Redirect output to a client's web browser (Xlsx)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        // Write and save
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');

        // Free Memory
        $spreadsheet->disconnectWorksheets();
        unset($spreadsheet);
        exit;
    }
}
