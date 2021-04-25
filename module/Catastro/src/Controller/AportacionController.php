<?php

declare(strict_types=1);

namespace Catastro\Controller;

//use Application\Entity\Contribuyente;
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
//use Catastro\Entity\TablaValorZona;
use Catastro\Entity\Contribuyente;
use Catastro\Form\ValidacionModalForm;

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
        $valorConstruccion = $this->entityManager->getRepository(TablaValorConstruccion::class)->findAll();
        $aportaciones = $this->entityManager->getRepository(Aportacion::class)->findAll();
        return new ViewModel(['aportaciones' => $aportaciones, 'valorConstruccions' => $valorConstruccion, 'form' => $form]);
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
                        'idSolicitud'   => $r->getIdSolicitud(),
                        'idAportacion'  => $r->getIdAportacion(),
                        'Contribuyente' => $r->getIdContribuyente()->getNombre(),
                        'Parcela'       => $r->getIdPredio()->getParcela(),
                        'Lote'          => $r->getIdPredio()->getLote(),
                        // 'Vigencia'      => $r->getFecha()->format('d-m-Y'),
                        // 'Pago'          => "$ ".number_format($r->getPago(), 4),
                        'UltimoPago'    => $r->getEjercicioFiscal(),
                        'Estatus'       => $r->getEstatus(),
                        'Opciones'      => "Cargando..."
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
        $contribuyenteId = (int)$this->params()->fromRoute('id', -1);
        $response = $this->getResponse();

        $aportacion =$this->entityManager->getRepository(Aportacion::class)->findAll();
        $contribuyente = $this->entityManager->getRepository(Contribuyente::class)->findOneByIdContribuyente($contribuyenteId);
        $valorConstruccion = $this->entityManager->getRepository(TablaValorConstruccion::class)->findAll();
       // $localidades = $this->opergobserviceadapter->obtenerLocalidadByCveEntidadFederativa("23", "09");
        //$girocomerciales = $this->opergobserviceadapter->obtenerGiroComercialByCveFte('MTULUM', "2020");

        // if ($contribuyente == null) {
        //     $this->layout()->setTemplate('error/404');
        //     $this->getResponse()->setStatusCode(404);
        // }

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $form->setData($data);
            if ($form->isValid()) {
                $data = $form->getData();
                $contribuyente = $this->entityManager->getRepository(Contribuyente::class)->findOneByIdContribuyente($data['parametro']);
                $this->aportacionManager->actualizarContribuyente($contribuyente, $data);
                $aportacion =$this->aportacionManager->guardar($data);
                if ($aportacion) {
                    $this->aportacionManager->pdf($data, $aportacion);
                }
            }
        }
        //return new ViewModel(['form' => $form, 'id' => $contribuyenteId, 'valorConstruccions' => $valorConstruccion, 'contribuyente'=> $contribuyente, 'localidades' => $localidades, 'girocomerciales' => $girocomerciales]);
        return new ViewModel(['form' => $form, 'id' => $contribuyenteId, 'valorConstruccions' => $valorConstruccion, 'contribuyente'=> $contribuyente]);
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
                }
                else {
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
        //$this->layout()->setTemplate('catastro/aportacion/index-validation');

        $aportaciones = $this->entityManager->getRepository(Aportacion::class)->findAll();
        $valorConstruccion = $this->entityManager->getRepository(TablaValorConstruccion::class)->findAll();

        $form = new ValidacionForm();
        $formModal = new ValidacionModalForm();
        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $form->setData($data);
            if ($form->isValid()) {
                $data = $form->getData();
                $aportacion = $this->entityManager->getRepository(Aportacion::class)->findOneByIdAportacion($data['padron_id']);
                if ($data['status'] == 1) {
                    $this->aportacionManager->update($aportacion, $data);
                    $this->flashMessenger()->addSuccessMessage('La aportacion ha sido confirmado');
                    return $this->redirect()->toRoute('aportacion/validacion');
                } else {
                    $this->aportacionManager->update($aportacion, $data);
                    $this->flashMessenger()->addErrorMessage('La aportacion ha sido cancelada');
                    return $this->redirect()->toRoute('aportacion/validacion');
                }
            }
        }

        return new ViewModel(['aportaciones' => $aportaciones, 'form' => $form, 'ValidacionForm' => $formModal, 'valorConstruccions' => $valorConstruccion]);
    }

    public function viewAction()
    {
        $request = $this->getRequest();
        $aportacionId = (int)$this->params()->fromRoute('id', -1);
        // AJAX response
        if ($request->isXmlHttpRequest()) {
            $aportacion = $this->entityManager->getRepository(Aportacion::class)->findOneByIdAportacion($aportacionId);
            $data = [
                'id_aportacion'     =>  $aportacion->getIdAportacion(),
                'vig'               =>  $aportacion->getFecha()->format('Y-m-d'),
                'terreno'           =>  $aportacion->getMetrosTerreno(),
                'valor_m2_zona'     =>  $aportacion->getValorZona(),
                'v_terreno'         =>  $aportacion->getValorTerreno(),
                'sup_m'             =>  $aportacion->getMetrosConstruccion(),
                'valor'             =>  $aportacion->getValorMtsConstruccion(),
                'valorConstruccion' =>  $aportacion->getValorMtsConstruccion(),
                'v_c'               =>  $aportacion->getValorConstruccion(),
                'a_total'           =>  $aportacion->getAvaluo(),
                'avaluo_hidden'     =>  $aportacion->getAvaluo(),
                'select_tasa'       =>  $aportacion->getTasa(),
                'tasa_hidden'       =>  $aportacion->getTasa(),
                'ejercicio_f'       =>  $aportacion->getEjercicioFiscal(),
                'pago_a'            =>  $aportacion->getPago(),
            ];

            $view = new JsonModel($data);
            $view->setTerminal(true);
        } else {
            if ($aportacionId < 0) {
                $this->layout()->setTemplate('error/404');
                $this->getResponse()->setStatusCode(404);
                return $response->setTemplate('error/404');
            }

            $aportacion = $this->entityManager->getRepository(Aportacion::class)->findOneByIdAportacion($aportacionId);

            if ($aportacion == null) {
                $this->layout()->setTemplate('error/404');
                $this->getResponse()->setStatusCode(404);
                return $response->setTemplate('error/404');
            }

            $view = new ViewModel(['aportacion' => $aportacion]);
        }
        return $view;
    }

    public function editAction()
    {
        $request = $this->getRequest();
        $response = $this->getResponse();
        $aportacionId = (int)$this->params()->fromRoute('id', -1);
        // AJAX response
        if ($request->isXmlHttpRequest()) {
            $formModal = new ValidacionModalForm();
            $data = $this->params()->fromPost();
            if ($request->isPost()) {
                $formModal->setData($request->getPost());
                if ($formModal->isValid()) {
                    $data = $formModal->getData();
                    $data['proceso'] = true;
                    $aportacion = $this->entityManager->getRepository(Aportacion::class)->findOneByIdAportacion($aportacionId);
                    $this->flashMessenger()->addSuccessMessage('Se actualizo con éxito');
                    $this->aportacionManager->actualizarValidation($aportacion, $data);
                } else {
                    $data['proceso'] = false;
                    $data['errors'] = $formModal->getMessages();
                };
                $view = new JsonModel($data);
                $view->setTerminal(true);
            }
        } else {
            $formModal = new ValidacionModalForm();
            if ($aportacionId < 0) {
                $this->layout()->setTemplate('error/404');
                $this->getResponse()->setStatusCode(404);
                return $response->setTemplate('error/404');
            }

            $aportacion = $this->entityManager->getRepository(Aportacion::class)->findOneByIdAportacion($aportacionId);

            if ($aportacion == null) {
                $this->layout()->setTemplate('error/404');
                $this->getResponse()->setStatusCode(404);
                return $response->setTemplate('error/404');
            }

            if ($this->getRequest()->isPost()) {
                $data = $this->params()->fromPost();
                $formModal->setData($data);
                if ($formModal->isValid()) {
                    $data = $formModal->getData();
                    $this->contribuyenteManager->actualizar($aportacion, $data);
                    return $this->redirect()->toRoute('aportacion');
                }
            } else {
                $data = [
                    // 'nombre' => $aportacion->getNombre(),
                    // 'apellido_paterno' => $aportacion->getApellidoPaterno(),
                    // 'apellido_materno' => $aportacion->getApellidoMaterno(),
                    // 'rfc' => $aportacion->getRfc(),
                    // 'curp' => $aportacion->getCurp(),
                    // 'genero' => $aportacion->getGenero(),
                    'pago_a'        =>  $aportacion->getPago(),
                ];
                $formModal->setData($data);
                $this->flashMessenger()->addInfoMessage('Se actualizo con éxito');
            }
            $view = new ViewModel(['ValidacionForm' => $formModal]);
        }
        return $view;
    }

    public function searchRfcAction()
    {
        $name = $_REQUEST['q'];

        $qb = $this->entityManager->createQueryBuilder();
        $qb->select('c')->from('Catastro\Entity\Contribuyente', 'c')
                ->where($qb->expr()->like('c.nombre', ":word"))
                ->orWhere($qb->expr()->like('c.apellidoPaterno', ":word"))
                ->orWhere($qb->expr()->like('c.apellidoMaterno', ":word"))
                ->orWhere($qb->expr()->like('c.rfc', ":word"))
                ->orWhere($qb->expr()->like('c.cvePersona', ":word"))
            ->setParameter("word", '%' . addcslashes($name, '%_') . '%');
        $query = $qb->getQuery()->getResult();

        $arreglo  = [];
        if ($query) {
            foreach ($query as $r) {
                $arreglo [] = [
                        'id' => $r->getIdContribuyente(),
                        'titular' => $r->getCvePersona().'-'.$r->getNombre(). ' ' .$r->getApellidoPaterno(). ' ' .$r->getApellidoMaterno() ,
                    ];
            }
        } else {
            $WebService = $this->opergobserviceadapter->obtenerNombrePersona($name);
            if (!(array)$WebService) {
                $WebService = $this->opergobserviceadapter->obtenerPersonaPorCve($name);
            }
            if (isset($WebService->Persona)) {
                if (is_array($WebService->Persona)) {
                    $WebServicePersona = [
                            'cve_persona'      => $WebService->Persona[0]->CvePersona,
                            'nombre'           => $WebService->Persona[0]->NombrePersona,
                            'apellido_paterno' => $WebService->Persona[0]->ApellidoPaternoPersona,
                            'apellido_materno' => $WebService->Persona[0]->ApellidoPaternoPersona,
                            'rfc'              => $WebService->Persona[0]->RFCPersona,
                            'curp'             => $WebService->Persona[0]->CURPPersona,
                            'razon_social'     => $WebService->Persona[0]->RazonSocialPersona,
                            'correo'           => $WebService->Persona[0]->PersonaCorreo,
                            'telefono'         => $WebService->Persona[0]->PersonaTelefono,
                            'genero'           => $WebService->Persona[0]->GeneroPersona,
                    ];

                    $contribuyente = $this->aportacionManager->guardarPersona($WebServicePersona);
                    if ($contribuyente) {
                        $arreglo[] = [
                                    'id' => $contribuyente->getIdContribuyente(),
                                    'titular' => $WebService->Persona[0]->CvePersona.' '.$WebService->Persona[0]->NombrePersona,
                                ];
                    }
                } else {
                    if (isset($WebService->Persona)) {
                        $WebServicePersona = [
                'apellido_paterno' => $WebService->Persona->ApellidoPaternoPersona,
                'apellido_materno' => $WebService->Persona->ApellidoMaternoPersona,
                'curp'             => $WebService->Persona->CURPPersona,
                'cve_persona'      => $WebService->Persona->CvePersona,
                'genero'           => $WebService->Persona->GeneroPersona,
                'nombre'           => $WebService->Persona->NombrePersona,
                'telefono'         => $WebService->Persona->PersonaTelefono,
                'correo'           => $WebService->Persona->PersonaCorreo,
                'rfc'              => $WebService->Persona->RFCPersona,
                'razon_social'     => $WebService->Persona->RazonSocialPersona,
            ];

                        $contribuyente = $this->aportacionManager->guardarPersona($WebServicePersona);
                        if ($contribuyente) {
                            $arreglo[] = [
                                'id' => $contribuyente->getIdContribuyente(),
                                'titular' => $WebService->Persona->CvePersona.' '.$WebService->Persona->NombrePersona,
                            ];
                        }
                    }
                }
            }
        }

        $data = [
                'items' => $arreglo,
                'total_count' => count($arreglo),
            ];


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

            $contribuyente = $this->entityManager->getRepository(Contribuyente::class)->findOneByIdContribuyente($id);
            $aportacion = $this->entityManager->getRepository(Aportacion::class)->findOneByIdContribuyente($id);

            $idpredio = $aportacion->getIdPredio();

            $qb = $this->entityManager->createQueryBuilder();
            $qb->select('p')
                ->from('Catastro\Entity\PredioColindancia', 'p')
                ->where('p.idPredio = :idParam')
                ->setParameter('idParam', $idpredio);
            $predioColindancias = $qb->getQuery()->getResult();

            foreach ($predioColindancias as $datos) {
                $medidas[]=$datos->getMedidaMetros();
                $descripcion[]=$datos->getDescripcion();
            }

            $predio = $this->entityManager->getRepository(Predio::class)->findOneByIdPredio($id);
            $data = [
                'parcela'           =>  $aportacion->getIdPredio()->getParcela(),
                'lote'              =>  $aportacion->getIdPredio()->getLote(),
                'local'             =>  $aportacion->getIdPredio()->getLocal(),
                'categoria'         =>  $aportacion->getIdPredio()->getCategoria(),
                'condicion'         =>  $aportacion->getIdPredio()->getCondicion(),
                'titular'           =>  $aportacion->getIdPredio()->getTitular(),
                'ubicacion'         =>  $aportacion->getIdPredio()->getUbicacion(),
                'localidad'         =>  $aportacion->getIdPredio()->getLocalidad(),
                'antecedentes'      =>  $aportacion->getIdPredio()->getAntecedentes(),
                'regimenPropiedad'  =>  $aportacion->getIdPredio()->getRegimenPropiedad(),
                'titular_anterior'  =>  $aportacion->getIdPredio()->getTitularAnterior(),
                'id_predio'         =>  $aportacion->getIdPredio()->getIdPredio(),
                'cvlCatastral'      =>  $aportacion->getIdPredio()->getClaveCatastral(),

                'idcontribuyente' =>  $contribuyente->getIdContribuyente(),
                'contribuyente'   =>  $contribuyente->getNombre(),
                'giroComercial'   =>  $contribuyente->getGiroComercial(),
                'nombreComercial' =>  $contribuyente->getNombreComercial(),
                'rfc'             =>  $contribuyente->getRfc(),
                'tenencia'        =>  $contribuyente->getTenencia(),
                'usoDestino'      =>  $contribuyente->getUsoDestino(),

                'norte'            =>  $medidas[0],
                'sur'              =>  $medidas[1],
                'este'             =>  $medidas[2],
                'oeste'            =>  $medidas[3],

                'con_norte'        =>  $descripcion[0],
                'con_sur'          =>  $descripcion[1],
                'con_este'         =>  $descripcion[2],
                'con_oeste'        =>  $descripcion[3],


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

    public function puffAction()
    {
        $html = ob_get_clean();
        // create new PDF document
        $pdf = new \TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        $pdf->setPrintHeader(false);

        // $padronId = (int)$this->params()->fromRoute('id', -1);
        $aportacionId = (int)$this->params()->fromRoute('id', -1);

        // Valida que el parametro exista si no devuelve 404 no encontrado
        if ($aportacionId < 0) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
        // Encuentra el id del dato consultado
        //$padron = $this->entityManager->getRepository(Padron::class)->findOneById($padronId);
        $aportacion = $this->entityManager->getRepository(Aportacion::class)->findOneByIdAportacion($aportacionId);

        // Si no devuelve informacion devuelve 404 no encontrado
        if ($aportacion == null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Nicola Asuni');
        $pdf->SetTitle('TCPDF Example 001');
        $pdf->SetSubject('TCPDF Tutorial');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

        // set default header data
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE . ' 001', PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
        $pdf->setFooterData(array(0, 64, 0), array(0, 64, 128));

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
        if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
            require_once(dirname(__FILE__) . '/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

        // ---------------------------------------------------------

        // set default font subsetting mode
        $pdf->setFontSubsetting(true);

        // Set font
        // dejavusans is a UTF-8 Unicode font, if you only need to
        // print standard ASCII chars, you can use core fonts like
        // helvetica or times to reduce file size.
        $pdf->SetFont('dejavusans', '', 14, '', true);

        // Add a page
        // This method has several options, check the source code documentation for more information.
        $pdf->AddPage();

        // set text shadow effect
        $pdf->setTextShadow(array('enabled' => true, 'depth_w' => 0.2, 'depth_h' => 0.2, 'color' => array(196, 196, 196), 'opacity' => 1, 'blend_mode' => 'Normal'));

        // Set some content to print
        $html = 'PAGO TOTAL DE APORTACION: $' . $aportacion->getPago() . '';
        //$html = 'PAGO TOTAL DE APORTACION: $';


        // Print text using writeHTMLCell()
        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

        // ---------------------------------------------------------

        // Close and output PDF document
        if (ob_get_contents()) {
            ob_end_clean();
        }

        // This method has several options, check the source code documentation for more information.
        $pdf->Output('listado_' . date('dmY') . '.pdf', 'D');

        //return new ViewModel();
    }

    public function pdfdirrectorAction()
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

        //Para eliminar la marca de agua de TCPDF
        $pdf->setPrintHeader(false);

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

        // set default font subsetting mode

        // Set font
        // dejavusans is a UTF-8 Unicode font, if you only need to
        // print standard ASCII chars, you can use core fonts like
        // helvetica or times to reduce file size.
        $pdf->SetFont('helvetica', 'B', 20);

        // Add a page
        // This method has several options, check the source code documentation for more information.
        $pdf->AddPage();

        //$pdf->Write(20, 'H.AYUNTAMIENTO DE TULUM', '', 0, 'C', true, 0, false, false, 0);

        $pdf->SetFont('helvetica', '', 10);
        // Encuentra el id del dato consultado
        $aportacionId = (int)$this->params()->fromRoute('id', -1);

        // Valida que el parametro exista si no devuelve 404 no encontrado
        if ($aportacionId < 0) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
        // Encuentra el id del dato consultado
        //$padron = $this->entityManager->getRepository(Padron::class)->findOneById($padronId);
        $aportacion = $this->entityManager->getRepository(Aportacion::class)->findOneByIdAportacion($aportacionId);

        // Si no devuelve informacion devuelve 404 no encontrado
        if ($aportacion == null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
        $contribuyente = $this->entityManager->getRepository(Contribuyente::class)->findOneByIdContribuyente($aportacion->getIdContribuyente());
        $predio = $this->entityManager->getRepository(Predio::class)->findOneByIdPredio($aportacion->getIdPredio());
        $idpredio = $aportacion->getIdPredio();

        $qb = $this->entityManager->createQueryBuilder();
        $qb->select('p')
                ->from('Catastro\Entity\PredioColindancia', 'p')
                ->where('p.idPredio = :idParam')
                ->setParameter('idParam', $idpredio);
        $predioColindancias = $qb->getQuery()->getResult();

        foreach ($predioColindancias as $datos) {
            $medidas[]=$datos->getMedidaMetros();
            $descripcion[]=$datos->getDescripcion();
        }

        $pdf->Image('public/img/tulum.png', 23, 20, 30, 30, 'PNG', '', '', true, 150, '', false, false, 0, false, false, false);
        $pdf->MultiCell(100, 30, '<h5><font size="11">H.AYUNTAMIENTO DE TULUM<br>TESORERIA MUNICIPAL<br>DIRECCION DE CATASTRO</font></h5>', 0, 'C', 0, 0, '55', '', true, 0, true);
        $pdf->Image('public/img/logo.png', 158, 20, 30, 30, 'PNG', '', '', true, 150, '', false, false, 0, false, false, false);
        $pdf->Ln(25);

        $tbl = '<table  cellspacing="0" cellpadding="1" border="1" style="border-color:gray; width:100%;">';
        $tbl .= '<tr style="background-color:#47A7AC;color:black;">
                    <th>PARCELA</th>
                    <th>MANZANA</th>
                    <th>LOTE</th>
                    <th>LOCAL</th>
                    <th>CATEGORIA</th>
                    <th>CONDICION</th>
                </tr>
                <tr>
                    <th><font size="7">'.$predio->getParcela().'</font></th>
                    <th><font size="7">'.$predio->getManzana().'</font></th>
                    <th><font size="7">'.$predio->getLote().'</font></th>
                    <th><font size="7">'.$predio->getLocal().'</font></th>
                    <th><font size="7">'.$predio->getCategoria().'</font></th>
                    <th><font size="7">'.$predio->getCondicion().'</font></th>
                </tr>
                <tr style="background-color:#9b9b9b;color:black;">
                <th colspan ="6" >DATOS DEL INMUEBE</th>
                </tr>
                <tr style="background-color:#47A7AC;color:black;">
                <th colspan ="2">TITULAR</th>
                <th colspan ="2">UBICACIÓN</th>
                <th colspan ="2">LOCALIDAD</th>
                </tr>
                <tr>
                    <th colspan ="2"><font size="7">'.$predio->getTitular().'</font></th>
                    <th colspan ="2"><font size="7">'.$predio->getUbicacion().'</font></th>
                    <th colspan ="2"><font size="7">'.$predio->getLocalidad().'</font></th>
                </tr>
                <tr style="background-color:#47A7AC;color:black;">
                <th colspan ="2">ANTECEDENTES</th>
                <th colspan ="4">MEDIDAS Y COLINDANCIAS</th>
                </tr>
                <tr>
                    <th rowspan="4" colspan ="2"><font size="7"><br><br><br>'.$predio->getAntecedentes().'</font></th>
                    <th><font size="7">AL NORTE:</font></th>
                    <th><font size="7">'.$medidas[0].'</font></th>
                    <th><font size="7">CON:</font></th>
                    <th><font size="7">'.$descripcion[0].'</font></th>
                </tr>
                <tr>
                    <th><font size="7">AL SUR:</font></th>
                    <th><font size="7">'.$medidas[1].'</font></th>
                    <th><font size="7">CON:</font></th>
                    <th><font size="7">'.$descripcion[1].'</font></th>
                </tr>
                <tr>
                    <th><font size="7">AL ESTE:</font></th>
                    <th><font size="7">'.$medidas[2].'</font></th>
                    <th><font size="7">CON:</font></th>
                    <th><font size="7">'.$descripcion[2].'</font></th>
                </tr>
                <tr>
                    <th><font size="7">AL OESTE</font></th>
                    <th><font size="7">'.$medidas[3].'</font></th>
                    <th><font size="7">CON:</font></th>
                    <th><font size="7">'.$descripcion[3].'</font></th>
                </tr>
                <tr style="background-color:#47A7AC;color:black;">
                <th colspan ="2">REGIMEN DE PROPIEDAD</th>
                <th colspan ="2">FECHA DE ADQUISICIÓN</th>
                <th colspan ="2">TITULAR ANTERIOR</th>
                </tr>
                <tr>
                    <th colspan ="2"><font size="7">'.$predio->getRegimenPropiedad().'</font></th>
                    <th colspan ="2"><font size="7">'.$aportacion->getFechaAdquicision()->format('d-m-Y').'</font></th>
                    <th colspan ="2"><font size="7">'.$predio->getTitularAnterior().'</font></th>
                </tr>
                <tr style="background-color:#9b9b9b;color:black;">
                <th colspan ="6" >REGISTRO FISCAL</th>
                </tr>
                <tr style="background-color:#47A7AC;color:black;">
                <th colspan ="2">CONTRIBUYENTE</th>
                <th colspan ="1">FACTURA</th>
                <th colspan ="1">GIRO COMERCIAL</th>
                <th colspan ="2">NOMBRE COMERCIAL</th>
                </tr>
                <tr>
                    <th colspan ="2"><font size="7">'.$contribuyente->getNombre().'</font></th>
                    <th colspan ="1"><font size="7">'.$aportacion->getFactura().'</font></th>
                    <th colspan ="1"><font size="7">'.$contribuyente->getGiroComercial().'</font></th>
                    <th colspan ="2"><font size="7">'.$contribuyente->getNombreComercial().'</font></th>
                </tr>
                <tr style="background-color:#47A7AC;color:black;">
                <th colspan ="2">TENENCIA</th>
                <th colspan ="2">RFC</th>
                <th colspan ="2">USO O DESTINO</th>
                </tr>
                <tr>
                    <th colspan ="2"><font size="7">'.$contribuyente->getTenencia().'</font></th>
                    <th colspan ="2"><font size="7">'.$contribuyente->getRfc().'</font></th>
                    <th colspan ="2"><font size="7">'.$contribuyente->getUsoDestino().'</font></th>
                </tr>
                <tr style="background-color:#9b9b9b;color:black;">
                <th colspan ="6" >AVALUO</th>
                </tr>
                <tr style="background-color:#47A7AC;color:black;">
                <th colspan ="2">SUP.M2 TERRENO</th>
                <th colspan ="2">VALOR M2 DE ZONA</th>
                <th colspan ="2">VALOR DEL TERRENO</th>
                </tr>
                <tr>
                    <th colspan ="2"><font size="7">'.$aportacion->getMetrosTerreno().'</font></th>
                    <th colspan ="2"><font size="7">$'.number_format($aportacion->getValorZona(), 4).'</font></th>
                    <th colspan ="2"><font size="7">$'.number_format($aportacion->getValorTerreno(), 4).'</font></th>
                </tr>
                <tr style="background-color:#47A7AC;color:black;">
                <th colspan ="2">SUP.M2 CONSTRUCCIÓN</th>
                <th colspan ="2">VALOR M2 CONSTRUCCION</th>
                <th colspan ="2">VALOR DE LA CONSTRUCCION</th>
                </tr>
                <tr>
                    <th colspan ="2"><font size="7">'.$aportacion->getMetrosConstruccion().'</font></th>
                    <th colspan ="2"><font size="7">$'.number_format($aportacion->getValorMtsConstruccion(), 4).'</font></th>
                    <th colspan ="2"><font size="7">$'.number_format($aportacion->getValorConstruccion(), 4).'</font></th>
                </tr>
                <tr style="background-color:#47A7AC;color:black;">
                <th>FECHA</th>
                <th>AVALUO</th>
                <th>TASA </th>
                <th colspan ="2">EJERCICIO FISCAL</th>
                <th>APORTACION</th>
                </tr>
                <tr>
                    <th><font size="7">'.$aportacion->getFecha()->format('d-m-Y').'</font></th>
                    <th><font size="7">$'.number_format($aportacion->getAvaluo()).'</font></th>
                    <th><font size="7">'.number_format($aportacion->getTasa(), 4).'</font></th>
                    <th colspan ="2"><font size="7">'.$aportacion->getEjercicioFiscal().'</font></th>
                    <th><font size="7">$'.number_format($aportacion->getPago(), 4).'</font></th>
                </tr>
                <tr style="background-color:#9b9b9b;color:black;">
                <th colspan ="6" >OBSERVACIONES</th>
                </tr>
                <tr>
                <th colspan ="6" ><font size="7">'.$aportacion->getObservaciones().'</font></th>
                </tr>
                <tr style="background-color:#9b9b9b;color:black;">
                <th colspan ="6" ></th>
                </tr>
                <tr>
                <th colspan ="6" ><font size="7">EL CALCULO DE LA CONTRIBUCIÓN QUE AMPARA ESTE DOCUMNTO, SE HACE A PETICION DEL SOLICITANTE Y EN NINGUN CASO SE CONSIDERA COMO PAGO DE IMPUESTO PREDIAL.
                ESTE DOCUMENTO NO CONSTITUYE UNA CEDULA CATASTRAL Y, POR TANTO, NO RECONOCE DERECHOS DE PROPIEDAD SOBRE EL INMUEBLE EN CUESTION A FAVOR DE PERSONA ALGUNA
                LA VIGENCIA DE ESTA TARJETA DE IDENTIFICACION ES ANUAL, PERO SERA INVALIDA POR FACTORES QUE MODIFIQUE SUS ELEMENTOS</font></th>
                </tr>
'
                ;
        $tbl = $tbl . '</table>';

        $pdf->writeHTML($tbl, true, 0, true, 0, 'C');
        $pdf->Ln(15);
        $pdf->MultiCell(58.66, 12, '<h6><font size="8">_________________________<br>ELABORO</font></h6>', 0, 'C', 0, 0, '17', '', true, 0, true);
        $pdf->MultiCell(58.66, 12, '<h6><font size="8">_________________________<br>JEFE DE DEPTO</font></h6>', 0, 'C', 0, 0, '', '', true, 0, true);
        $pdf->MultiCell(58.66, 12, '<h6><font size="8">_________________________<br>DIRECTOR</font></h6>', 0, 'C', 0, 0, '', '', true, 0, true);

        // move pointer to last page
        $pdf->lastPage();


        // ---------------------------------------------------------

        // Close and output PDF document
        if (ob_get_contents()) {
            ob_end_clean();
        }

        // This method has several options, check the source code documentation for more information.
        $pdf->Output('listadoPdf_' . date('dmY') . '.pdf', 'D');
        $pdf->Output();
        //============================================================+
        // END OF FILE
        //============================================================+# code...
    }

    public function searchAportacionAction()
    {
        $name = $_REQUEST['q'];

        // $qb = $this->entityManager->createQueryBuilder();
        // $qb->select('c')->from('Catastro\Entity\Contribuyente', 'c')
        //         ->where($qb->expr()->like('c.nombre', ":word"))
        //         ->orWhere($qb->expr()->like('c.apellidoPaterno', ":word"))
        //         ->orWhere($qb->expr()->like('c.apellidoMaterno', ":word"))
        //         ->orWhere($qb->expr()->like('c.rfc', ":word"))
        //         ->orWhere($qb->expr()->like('c.cvePersona', ":word"))
        //     ->setParameter("word", '%' . addcslashes($name, '%_') . '%');
        /////////////////////////////////////////////////////////
        $qb = $this->entityManager->createQueryBuilder();
        $qb ->select('p')->from('Catastro\Entity\Predio', 'p')
            ->where($qb->expr()->like('p.parcela', ":word"))
            ->orWhere($qb->expr()->like('p.titular', ":word"))
            ->setParameter("word", '%' . addcslashes($name, '%_') . '%');

        $query = $qb->getQuery()->getResult();

        $arreglo  = [];
        if ($query) {
            foreach ($query as $r) {
                $arreglo [] = [
                        'id' => $r->getIdContribuyente()->getIdContribuyente(),
                        'titular' => 'Parcela: '.$r->getParcela(). ' Titular: '.$r->getTitular(),
                    ];
            }
        }
        else if($query == null){
        $qb = $this->entityManager->createQueryBuilder();
        $qb ->select('c')->from('Catastro\Entity\Contribuyente', 'c')
            ->where($qb->expr()->like('c.nombre', ":word"))
            ->setParameter("word", '%' . addcslashes($name, '%_') . '%');

        $query = $qb->getQuery()->getResult();

        $arreglo  = [];
        if ($query) {
            foreach ($query as $r) {
                $arreglo [] = [
                        'id' => $r->getIdContribuyente(),
                        'titular' => 'Nombre: '.$r->getNombre(),
                    ];
            }

        }
        }
        // else if($query == null){
        // $qb = $this->entityManager->createQueryBuilder();
        // $qb ->select('p')->from('Catastro\Entity\Predio', 'p')
        //     ->where($qb->expr()->like('p.parcela', ":word"))
        //     ->setParameter("word", '%' . addcslashes($name, '%_') . '%');

        // $query = $qb->getQuery()->getResult();

        // $arreglo  = [];
        // if ($query) {
        //     foreach ($query as $r) {
        //         $arreglo [] = [
        //                 'id' => $r->getIdPredio(),
        //                 'titular' => $r->getParcela().'-Parcela',
        //             ];
        //     }

        // }
        // }

        $data = [
                'items' => $arreglo,
                'total_count' => count($arreglo),
            ];


        $json = new JsonModel($data);
        $json->setTerminal(true);

        return $json;
    }

    public function autofillAportacionAction()
    {
        $request = $this->getRequest();
        $response = $this->getResponse();
        // AJAX response
        if ($request->isXmlHttpRequest()) {
            $id = $this->params()->fromRoute('id');

            $contribuyente = $this->entityManager->getRepository(Contribuyente::class)->findOneByIdContribuyente($id);
            $aportacion = $this->entityManager->getRepository(Aportacion::class)->findOneByIdContribuyente($id);

            $idpredio = $aportacion->getIdPredio();

            $qb = $this->entityManager->createQueryBuilder();
            $qb->select('p')
                ->from('Catastro\Entity\PredioColindancia', 'p')
                ->where('p.idPredio = :idParam')
                ->setParameter('idParam', $idpredio);
            $predioColindancias = $qb->getQuery()->getResult();

            foreach ($predioColindancias as $datos) {
                $medidas[]=$datos->getMedidaMetros();
                $descripcion[]=$datos->getDescripcion();
            }

            $predio = $this->entityManager->getRepository(Predio::class)->findOneByIdPredio($id);
            $data = [
                // 'parcela'           =>  $aportacion->getIdPredio()->getParcela(),
                'contribuyente'           =>  $aportacion->getIdContribuyente()->getNombre(),
                // 'lote'              =>  $aportacion->getIdPredio()->getLote(),
                // 'local'             =>  $aportacion->getIdPredio()->getLocal(),
                // 'categoria'         =>  $aportacion->getIdPredio()->getCategoria(),
                // 'condicion'         =>  $aportacion->getIdPredio()->getCondicion(),
                // 'titular'           =>  $aportacion->getIdPredio()->getTitular(),
                // 'ubicacion'         =>  $aportacion->getIdPredio()->getUbicacion(),
                // 'localidad'         =>  $aportacion->getIdPredio()->getLocalidad(),
                // 'antecedentes'      =>  $aportacion->getIdPredio()->getAntecedentes(),
                // 'regimenPropiedad'  =>  $aportacion->getIdPredio()->getRegimenPropiedad(),
                // 'titular_anterior'  =>  $aportacion->getIdPredio()->getTitularAnterior(),
                // 'id_predio'         =>  $aportacion->getIdPredio()->getIdPredio(),
                // 'cvlCatastral'      =>  $aportacion->getIdPredio()->getClaveCatastral(),

                // 'idcontribuyente' =>  $contribuyente->getIdContribuyente(),
                // 'contribuyente'   =>  $contribuyente->getNombre(),
                // 'giroComercial'   =>  $contribuyente->getGiroComercial(),
                // 'nombreComercial' =>  $contribuyente->getNombreComercial(),
                // 'rfc'             =>  $contribuyente->getRfc(),
                // 'tenencia'        =>  $contribuyente->getTenencia(),
                // 'usoDestino'      =>  $contribuyente->getUsoDestino(),

                // 'norte'            =>  $medidas[0],
                // 'sur'              =>  $medidas[1],
                // 'este'             =>  $medidas[2],
                // 'oeste'            =>  $medidas[3],

                // 'con_norte'        =>  $descripcion[0],
                // 'con_sur'          =>  $descripcion[1],
                // 'con_este'         =>  $descripcion[2],
                // 'con_oeste'        =>  $descripcion[3],


            ];

            return $response->setContent(json_encode($data));
        } else {
            echo 'Error get data from ajax';
        }
    }

    public function viewAportacionAction(){
        $aportacionId = (int)$this->params()->fromRoute('id', -1);
        $apotacion = $this->entityManager->getRepository(Aportacion::class)->findOneByIdAportacion($aportacionId);
        if ($apotacion == null) {
            $this->layout()->setTemplate('error/404');
            $this->getResponse()->setStatusCode(404);
        }

        return new ViewModel(['aportacionId' => $aportacionId]);
    }

    public function editAportacionAction(){


        $request = $this->getRequest();
        $aportacionId = (int)$this->params()->fromRoute('id', -1);
        // AJAX response
        if ($request->isXmlHttpRequest()) {
            $aportacion = $this->entityManager->getRepository(Aportacion::class)->findOneByIdAportacion($aportacionId);
            $data = [
                //Predio////
                'parcela'            => $aportacion->getIdPredio()->getParcela(),
                'manzana'            => $aportacion->getIdPredio()->getManzana(),
                'lote'               => $aportacion->getIdPredio()->getLote(),
                'local'              => $aportacion->getIdPredio()->getlocal(),
                'categoria'          => $aportacion->getIdPredio()->getCategoria(),
                'condicion'          => $aportacion->getIdPredio()->getCondicion(),
                'titular'            => $aportacion->getIdPredio()->getTitular(),
                'ubicacion'          => $aportacion->getIdPredio()->getUbicacion(),
                'localidad'          => $aportacion->getIdPredio()->getLocalidad(),
                'antecedentes'       => $aportacion->getIdPredio()->getAntecedentes(),
                'claveCatastral'     => $aportacion->getIdPredio()->getClaveCatastral(),
                'regimenPropiedad'   => $aportacion->getIdPredio()->getRegimenPropiedad(),
                'fechaAdquicision'   => $aportacion->getIdPredio()->getFechaAdquicision()->format('Y-m-d'),
                'titularAnterior'    => $aportacion->getIdPredio()->getTitularAnterior(),
                'documentoPropiedad' => $aportacion->getIdPredio()->getParcela(),
                'folio'              => $aportacion->getIdPredio()->getParcela(),
                'fechaDocumento'     => $aportacion->getIdPredio()->getParcela(),
                'loteConflicto'      => $aportacion->getIdPredio()->getParcela(),
                'observaciones'      => $aportacion->getIdPredio()->getObservaciones(),
                ///Contiribuyente//
                'contribuyente'      => $aportacion->getIdContribuyente()->getNombre(),
                'factura'            => $aportacion->getIdContribuyente()->getFactura(),
                'giroComercial'      => $aportacion->getIdContribuyente()->getGiroComercial(),
                'nombreComercial'    => $aportacion->getIdContribuyente()->getNombreComercial(),
                'tenencia'           => $aportacion->getIdContribuyente()->getTenencia(),
                'rfc'                => $aportacion->getIdContribuyente()->getRfc(),
                'usoDestino'         => $aportacion->getIdContribuyente()->getUsoDestino(),
                ///Aportacion

            ];

            $view = new JsonModel($data);

        }
        return $view;


    }

    public function updateAportacionAction(){

        $req_post = $this->params()->fromPost();

        $result = $this->aportacionManager->actualizarAportacion($req_post['a'][0]);
        $json = new JsonModel($datos);
				$json->setTerminal(true);


            $datos = ["resp"=>"ok", "msg"=>"cambios guardados"];

            $json = new JsonModel($datos);
			$json->setTerminal(true);

            return $json;

    }


    public function addTestAction()
    {
        $req_post = $this->params()->fromPost();

        $result = $this->aportacionManager->guardarTest($req_post['c'][0]);

        if ($result){
            $datos = ["resp"=>"ok", "msg"=>"cambios guardados", 'id_objeto' =>$result->getIdAportacion(), 'nombre' =>$result->getIdContribuyente()->getNombre()];
        }else{
            $datos = ["resp"=>"no", "msg"=>"Np se guardo"];
        }

				$json = new JsonModel($datos);
				$json->setTerminal(true);

				return $json;
    }

    public function addAportacionAction()
    {
        $req_post = $this->params()->fromPost();

        $result = $this->aportacionManager->guardarAportacion($req_post['a'][0]);

				$json = new JsonModel($datos);
				$json->setTerminal(true);

				return $json;



    }
////////DataTable Jquery///////////////
    public function datatableColindanciasAction()
    {
        $request = $this->getRequest();
        $response = $this->getResponse();

            $req_post = $this->params()->fromPost();

            $idpredio = $req_post['id_predio'];

            $qb = $this->entityManager->createQueryBuilder();
            $qb->select('p')
                ->from('Catastro\Entity\PredioColindancia', 'p')
                ->where('p.idPredio = :idParam')
                ->setParameter('idParam', $idpredio);
            $predioColindancias = $qb->getQuery()->getResult();


            $data = [];

            foreach ($predioColindancias as $r) {
                $data[] = [
                        'idColindancia'    => $r->getIdPredioColindancia(),
                        'puntoCardinal'    => $r->getPuntoCardinal(),
                        'metrosLineales'   => $r->getMedidaMetrosLineales(),
                        'colindancia'      => $r->getColindancia(),
                        'observaciones'    => $r->getObservaciones(),
                        'Opciones'         => "Cargando..."
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
    ///////////Agregar Datatbale Colindancias /////////
    public function addcolindanciasAction()
    {
        $req_post = $this->params()->fromPost();

        $result = $this->aportacionManager->guardarColindancias($req_post['c'][0]);

        if ($result){
            $datos = ["resp"=>"ok", "msg"=>"cambios guardados", 'id_objeto' =>$result->getIdAportacion(), 'id_predio' =>$result->getIdPredio()->getIdPredio()];
        }else{
            $datos = ["resp"=>"no", "msg"=>"Np se guardo"];
        }

				$json = new JsonModel($datos);
				$json->setTerminal(true);

				return $json;

    }
       ///////////Eliminar Datatbale Colindancias/////////
    public function deletecolindanciasAction()
    {
        $req_post = $this->params()->fromPost();

        $id_predioColindancias = $req_post['c'][0];
        $predioColindancias = $this->entityManager->getRepository(PredioColindancia::class)->findOneByIdPredioColindancia($id_predioColindancias);
        $this->aportacionManager->eliminarColindancias($predioColindancias);

        $datos = ["resp"=>"ok", "msg"=>"se elimino correctamente"];

				$json = new JsonModel($datos);
				$json->setTerminal(true);

				return $json;


    }
    ///////////Editar Datatbale Colindancias/////////
        public function editColindanciaAction(){


        $request = $this->getRequest();
        $predioColindanciasId = (int)$this->params()->fromRoute('id', -1);
        // AJAX response
        if ($request->isXmlHttpRequest()) {
            $predioColindancia = $this->entityManager->getRepository(PredioColindancia::class)->findOneByIdPredioColindancia($predioColindanciasId);
            $data = [

                'idPredioColindancias'         => $predioColindancia->getIdPredioColindancia(),
                'puntoCardinal'                => $predioColindancia->getPuntoCardinal(),
                'colindaCon'                   => $predioColindancia->getColindancia(),
                'medidasMetros'                => $predioColindancia->getMedidaMetrosLineales(),
                'observacionesColindacias'     => $predioColindancia->getObservaciones(),


            ];

            $view = new JsonModel($data);

        }
        return $view;


    }
     ///////////Actualizar Datatbale Colindancias/////////
    public function updateColindanciasAction(){


        $req_post = $this->params()->fromPost();

        $result = $this->aportacionManager->actualizarColindancias($req_post['c'][0]);


            $datos = ["resp"=>"ok", "msg"=>"se actualizo correctamente"];

            $json = new JsonModel($datos);
			$json->setTerminal(true);

            return $json;

    }




}
