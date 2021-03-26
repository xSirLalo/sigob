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
use Catastro\Entity\TablaValorZona;
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
        $contribuyente = $this->entityManager->getRepository(Contribuyente::class)->findAll();
        $valorConstruccion = $this->entityManager->getRepository(TablaValorConstruccion::class)->findAll();
        $valoresZona = $this->entityManager->getRepository(TablaValorZona::class)->findAll();

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
        return new ViewModel(['form' => $form, 'id' => $parametro, 'valorConstruccions' => $valorConstruccion, 'valoresZonas' => $valoresZona]);
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
        $formModal = new ValidacionModalForm();
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

        return new ViewModel(['aportaciones' => $aportaciones, 'form' => $form, 'ValidacionForm' => $formModal]);
    }

    public function viewAction()
    {
        $request = $this->getRequest();
        $aportacionId = (int)$this->params()->fromRoute('id', -1);
        // AJAX response
        if ($request->isXmlHttpRequest()) {
            $aportacion = $this->entityManager->getRepository(Aportacion::class)->findOneByIdAportacion($aportacionId);
            $data = [
                'id_aportacion' =>  $aportacion->getIdAportacion(),
                'terreno'       =>  $aportacion->getMetrosTerreno(),
                'v_terreno'     =>  $aportacion->getValorTerreno(),
                'sup_m'         =>  $aportacion->getMetrosConstruccion(),
                'v_c'           =>  $aportacion->getValorConstruccion(),
                'a_total'       =>  $aportacion->getAvaluo(),
                'vig'           =>  $aportacion->getFecha()->format('Y-m-d'),
                'pago_a'        =>  $aportacion->getPago(),
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
                        'titular' => $r->getNombre(). ' ' .$r->getApellidoPaterno(). ' ' .$r->getApellidoMaterno() ,
                    ];
            }
        } else {
            $WebService = $this->opergobserviceadapter->obtenerPersonaPorCve($name);
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
                'titular'          =>  $aportacion->getIdPredio()->getTitular(),
                'ubicacion'        =>  $aportacion->getIdPredio()->getUbicacion(),
                'titular_anterior' =>  $aportacion->getIdPredio()->getTitularAnterior(),
                'id_predio'        =>  $aportacion->getIdPredio()->getIdPredio(),
                'cvlCatastral'     =>  $aportacion->getIdPredio()->getClaveCatastral(),

                'idcontribuyente' =>  $contribuyente->getIdContribuyente(),

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
}
