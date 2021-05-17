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
use Catastro\Entity\GiroComercial;
use Catastro\Entity\Localidad;
use Catastro\Entity\UsoDestino;
use Catastro\Entity\Condicion;
use Catastro\Entity\Categoria;
use Catastro\Entity\RegimenPropiedad;
use Catastro\Entity\DocumentoPropiedad;

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
        $postData = $_POST;

        $columns = [
            0 => 'idSolicitud',
            1 => 'idAportacion',
            2 => 'Contribuyente',
            3 => 'Propietario',
            4 => 'Parcela',
            5 => 'Lote',
            6 => 'UltimoPago',
            7 => 'Estatus',
            8 => 'Opciones',
        ];

        // AJAX response
        if ($request->isXmlHttpRequest()) {
            $qb = $this->entityManager->createQueryBuilder();

            $qb ->select('a')
            ->from('Catastro\Entity\Aportacion', 'a')
            ->join('Catastro\Entity\Contribuyente', 'c', \Doctrine\ORM\Query\Expr\Join::WITH, 'a.idContribuyente = c.idContribuyente')
            ->join('Catastro\Entity\Predio', 'p', \Doctrine\ORM\Query\Expr\Join::WITH, 'a.idPredio = p.idPredio')
            ->where('a.estatus = 1')
            ->orWhere('a.estatus = 2')
            ->orWhere('a.estatus = 3');
            $count = $qb->getQuery()->getScalarResult();


            $searchKeyWord = htmlspecialchars($postData['search']['value']);
            $filter_options = htmlspecialchars($postData['filter_options']);
            if (isset($searchKeyWord)) {
                $searchKeyWord = htmlspecialchars($postData['search']['value']);
                if ($filter_options == "0") {
                    $qb ->where('a.estatus = 3 and a.idAportacion LIKE :word')
                    ->orWhere('a.estatus = 2 and a.idAportacion LIKE :word')
                    ->orWhere('a.estatus = 1 and a.idAportacion LIKE :word')
                    ->setParameter("word", '%'.addcslashes($searchKeyWord, '%_').'%');
                } elseif ($filter_options == "1") {
                    $qb ->where('a.estatus = 3 and p.parcela LIKE :word')
                    ->orWhere('a.estatus = 2 and p.parcela LIKE :word')
                    ->orWhere('a.estatus = 1 and p.parcela LIKE :word')
                    ->setParameter("word", '%'.addcslashes($searchKeyWord, '%_').'%');
                } elseif ($filter_options == "2") {
                    $qb ->where('a.estatus = 3 and c.nombre LIKE :word')
                    ->orWhere('a.estatus = 2 and c.nombre LIKE :word')
                    ->orWhere('a.estatus = 1 and c.nombre LIKE :word')
                    ->setParameter("word", '%'.addcslashes($searchKeyWord, '%_').'%');
                } elseif ($filter_options == "3") {
                    $qb ->where('a.estatus = 3 and p.titular LIKE :word')
                        ->orWhere('a.estatus = 2 and p.titular LIKE :word')
                        ->orWhere('a.estatus = 1 and p.titular LIKE :word')
                    ->setParameter("word", '%'.addcslashes($searchKeyWord, '%_').'%');
                } else {
                    $qb ->where('a.estatus = 3 and a.idAportacion LIKE :word')
                        ->orWhere('a.estatus = 2 and a.idAportacion LIKE :word')
                        ->orWhere('a.estatus = 1 and a.idAportacion LIKE :word')
                        ->orWhere('a.estatus = 3 and p.parcela LIKE :word')
                        ->orWhere('a.estatus = 2 and p.parcela LIKE :word')
                        ->orWhere('a.estatus = 1 and p.parcela LIKE :word')
                        ->orWhere('a.estatus = 3 and c.nombre LIKE :word')
                        ->orWhere('a.estatus = 2 and c.nombre LIKE :word')
                        ->orWhere('a.estatus = 1 and c.nombre LIKE :word')
                        ->orWhere('a.estatus = 3 and p.titular LIKE :word')
                        ->orWhere('a.estatus = 2 and p.titular LIKE :word')
                        ->orWhere('a.estatus = 1 and p.titular LIKE :word')
                        ->setParameter("word", '%'.addcslashes($searchKeyWord, '%_').'%');
                }
            }

            if (isset($postData['order'])) {
                //$qb ->orderBy('a.'. $columns[$postData['order'][0]['column']], $postData['order'][0]['dir']);
                $qb ->orderBy('a.idAportacion', 'DESC');
            } else {
                $qb ->orderBy('a.idAportacion', 'DESC');
            }

            if ($postData['length'] != -1) {
                $qb ->setFirstResult($postData['start'])->setMaxResults($postData['length']);
            }



            $query = $qb->getQuery()->getResult();

            $data = [];
            foreach ($query as $r) {
                $data[] = [
                    'idSolicitud'   => $r->getIdSolicitud(),
                    'idAportacion'  => $r->getIdAportacion(),
                    'Contribuyente' => $r->getIdContribuyente()->getNombre(),
                    'Propietario'   => $r->getIdPredio()->getTitular(),
                    'Parcela'       => $r->getIdPredio()->getParcela(),
                    'Lote'          => $r->getIdPredio()->getLote(),
                    'UltimoPago'    => $r->getEjercicioFiscalFinal(),
                    'Estatus'       => $r->getEstatus(),
                    'Opciones'      => "Cargando..."
                ];
            }


            $result = [
                    "draw"            => intval($postData['draw']),
                    "recordsTotal"    => count($count),
                    "recordsFiltered" => count($count),
                    'data'            => $data
                ];

            return $response->setContent(json_encode($result));
        }
    }


    public function addAction()
    {
        $form = new AportacionForm();

        $aportacion =$this->entityManager->getRepository(Aportacion::class)->findAll();
        $valorConstruccion = $this->entityManager->getRepository(TablaValorConstruccion::class)->findAll();
        $localidades = $this->entityManager->getRepository(localidad::class)->findAll();
        $girocomerciales = $this->entityManager->getRepository(GiroComercial::class)->findAll();
        $usodestino = $this->entityManager->getRepository(UsoDestino::class)->findAll();
        $condicion = $this->entityManager->getRepository(Condicion::class)->findAll();
        $categoria = $this->entityManager->getRepository(Categoria::class)->findAll();
        $regimenPropiedad = $this->entityManager->getRepository(RegimenPropiedad::class)->findAll();
        $documentoPropiedad = $this->entityManager->getRepository(DocumentoPropiedad::class)->findAll();

        return new ViewModel(['form' => $form, 'valorConstruccions' => $valorConstruccion, 'localidades' => $localidades, 'girocomerciales' => $girocomerciales, 'usodestinos' => $usodestino, 'condiciones' => $condicion , 'categorias' => $categoria, 'regimenPropiedades' => $regimenPropiedad, 'documentoPropiedades' => $documentoPropiedad]);

    }

    public function validationAction()
    {
        $valorConstruccion = $this->entityManager->getRepository(TablaValorConstruccion::class)->findAll();
        $formModal = new ValidacionModalForm();

        return new ViewModel(['ValidacionForm' => $formModal, 'valorConstruccions' => $valorConstruccion]);
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
                'p_hide'            =>  $aportacion->getPago(),
            ];

            $view = new JsonModel($data);
        }
        return $view;
    }

    public function editAction()
    {
        $req_post = $this->params()->fromPost();

        $aportacionId = $req_post['a'][0]['id'];
        $aportacion = $this->entityManager->getRepository(Aportacion::class)->findOneByIdAportacion($aportacionId);

        $this->aportacionManager->actualizarValidation($aportacion, $req_post['a'][0]);


        $datos = ["resp"=>"ok", "msg"=>"se actualizo correctamente"];

        $json = new JsonModel($datos);
        $json->setTerminal(true);

        return $json;


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
            if (empty($WebService->Persona)) {
                //$WebService = $this->opergobserviceadapter->obtenerPersonaPorCve($name);
                $WebService = $this->opergobserviceadapter->obtenerPersonaPorRfc($name);
            }
            if (isset($WebService->Persona)) {
                if (is_array($WebService->Persona)) {
                    $WebServicePersona = [
                            'cve_persona'      => $WebService->Persona[0]->CvePersona,
                            'nombre'           => $WebService->Persona[0]->NombrePersona,
                            'apellido_paterno' => $WebService->Persona[0]->ApellidoPaternoPersona,
                            'apellido_materno' => $WebService->Persona[0]->ApellidoMaternoPersona,
                            'rfc'              => $WebService->Persona[0]->RFCPersona,
                            'curp'             => $WebService->Persona[0]->CURPPersona,
                            'tipo_persona'     => $WebService->Persona[0]->TipoPersona,
                            'razon_social'     => $WebService->Persona[0]->RazonSocialPersona,
                            'correo'           => $WebService->Persona[0]->PersonaCorreo,
                            'telefono'         => $WebService->Persona[0]->PersonaTelefono,
                            'genero'           => $WebService->Persona[0]->GeneroPersona,
                    ];
                } else {
                    if (isset($WebService->Persona)) {
                        $WebServicePersona = [
                            'apellido_paterno' => $WebService->Persona->ApellidoPaternoPersona,
                            'apellido_materno' => $WebService->Persona->ApellidoMaternoPersona,
                            'curp'             => $WebService->Persona->CURPPersona,
                            'tipo_persona'     => $WebService->Persona->TipoPersona,
                            'cve_persona'      => $WebService->Persona->CvePersona,
                            'genero'           => $WebService->Persona->GeneroPersona,
                            'nombre'           => $WebService->Persona->NombrePersona,
                            'telefono'         => $WebService->Persona->PersonaTelefono,
                            'correo'           => $WebService->Persona->PersonaCorreo,
                            'rfc'              => $WebService->Persona->RFCPersona,
                            'razon_social'     => $WebService->Persona->RazonSocialPersona,
                        ];
                    }
                }
                if (!$WebServicePersona['cve_persona'] == null) {
                    $contribuyente = $this->aportacionManager->guardarPersona($WebServicePersona);
                }
                    if ($contribuyente) {
                        $arreglo[] = [
                            'id' => $contribuyente->getIdContribuyente(),
                            'titular' => $WebServicePersona['cve_persona'].' '.$WebServicePersona['nombre'].' '.$WebServicePersona['apellido_paterno'].' '.$WebServicePersona['apellido_materno'],
                        ];
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

    public function autofillRfcAction()
    {
        $request = $this->getRequest();
        $response = $this->getResponse();
        // AJAX response
        if ($request->isXmlHttpRequest()) {
            $id = $this->params()->fromRoute('id');

            $contribuyente = $this->entityManager->getRepository(Contribuyente::class)->findOneByIdContribuyente($id);
            $aportacion = $this->entityManager->getRepository(Aportacion::class)->findOneByIdContribuyente($id);
            $predio = $this->entityManager->getRepository(Predio::class)->findOneByIdPredio($id);

            $data = [
                'idcontribuyente' =>  $contribuyente->getIdContribuyente(),
                'contribuyente'   =>  $contribuyente->getNombre(),
                'apellidoPaterno' =>  $contribuyente->getApellidoPaterno(),
                'apellidoMaterno' =>  $contribuyente->getApellidoMaterno(),
                'giroComercial'   =>  $contribuyente->getGiroComercial(),
                'nombreComercial' =>  $contribuyente->getNombreComercial(),
                'rfc'             =>  $contribuyente->getRfc(),
                'tenencia'        =>  $contribuyente->getTenencia(),
                'usoDestino'      =>  $contribuyente->getUsoDestino(),
                ];

            return $response->setContent(json_encode($data));
        } else {
            echo 'Error get data from ajax';
        }
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

        $pdf->SetFont('helvetica', 'B', 20);

        $pdf->AddPage();

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
            $puntoCardinal[]=$datos->getPuntoCardinal();
            $medidas[]=$datos->getMedidaMetrosLineales();
            $descripcion[]=$datos->getColindancia();
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
                    <th><font size="7">AL '.$puntoCardinal[0].':</font></th>
                    <th><font size="7">'.$medidas[0].'</font></th>
                    <th><font size="7">CON:</font></th>
                    <th><font size="7">'.$descripcion[0].'</font></th>
                </tr>
                <tr>
                    <th><font size="7">AL '.$puntoCardinal[1].':</font></th>
                    <th><font size="7">'.$medidas[1].'</font></th>
                    <th><font size="7">CON:</font></th>
                    <th><font size="7">'.$descripcion[1].'</font></th>
                </tr>
                <tr>
                    <th><font size="7">AL '.$puntoCardinal[2].':</font></th>
                    <th><font size="7">'.$medidas[2].'</font></th>
                    <th><font size="7">CON:</font></th>
                    <th><font size="7">'.$descripcion[2].'</font></th>
                </tr>
                <tr>
                    <th><font size="7">AL '.$puntoCardinal[3].'</font></th>
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
                    <th colspan ="2"><font size="7">'.$predio->getFechaAdquicision()->format('d-m-Y').'</font></th>
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
                    <th colspan ="1"><font size="7">'.$contribuyente->getFactura().'</font></th>
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
                    <th colspan ="2"><font size="7">$'.number_format($aportacion->getValorZona(), 2).'</font></th>
                    <th colspan ="2"><font size="7">$'.number_format($aportacion->getValorTerreno(), 2).'</font></th>
                </tr>
                <tr style="background-color:#47A7AC;color:black;">
                <th colspan ="2">SUP.M2 CONSTRUCCIÓN</th>
                <th colspan ="2">VALOR M2 CONSTRUCCION</th>
                <th colspan ="2">VALOR DE LA CONSTRUCCION</th>
                </tr>
                <tr>
                    <th colspan ="2"><font size="7">'.$aportacion->getMetrosConstruccion().'</font></th>
                    <th colspan ="2"><font size="7">$'.number_format($aportacion->getValorMtsConstruccion(), 2).'</font></th>
                    <th colspan ="2"><font size="7">$'.number_format($aportacion->getValorConstruccion(), 2).'</font></th>
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
                    <th colspan ="2"><font size="7">'.$aportacion->getEjercicioFiscal().'-'.$aportacion->getEjercicioFiscalFinal().'</font></th>
                    <th><font size="7">$'.number_format($aportacion->getPago(), 2).'</font></th>
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

    public function viewAportacionAction()
    {
        $form = new AportacionForm();

        $aportacionId = (int)$this->params()->fromRoute('id', -1);
        $apotacion = $this->entityManager->getRepository(Aportacion::class)->findOneByIdAportacion($aportacionId);
        $valorConstruccion = $this->entityManager->getRepository(TablaValorConstruccion::class)->findAll();
        $localidades = $this->entityManager->getRepository(localidad::class)->findAll();
        $girocomerciales = $this->entityManager->getRepository(GiroComercial::class)->findAll();
        $usodestino = $this->entityManager->getRepository(UsoDestino::class)->findAll();
        $condicion = $this->entityManager->getRepository(Condicion::class)->findAll();
        $categoria = $this->entityManager->getRepository(Categoria::class)->findAll();
        $regimenPropiedad = $this->entityManager->getRepository(RegimenPropiedad::class)->findAll();
        $documentoPropiedad = $this->entityManager->getRepository(DocumentoPropiedad::class)->findAll();

        return new ViewModel(['aportacionId' => $aportacionId,'predio_id' => $apotacion->getIdPredio()->getIdPredio(), 'form' => $form, 'valorConstruccions' => $valorConstruccion, 'localidades' => $localidades, 'girocomerciales' => $girocomerciales, 'usodestinos' => $usodestino, 'condiciones' => $condicion , 'categorias' => $categoria, 'regimenPropiedades' => $regimenPropiedad, 'documentoPropiedades' => $documentoPropiedad]);
    }

    public function editAportacionAction()
    {
        $request = $this->getRequest();
        $aportacionId = (int)$this->params()->fromRoute('id', -1);
        // AJAX response
        if ($request->isXmlHttpRequest()) {
            $aportacion = $this->entityManager->getRepository(Aportacion::class)->findOneByIdAportacion($aportacionId);
            $data = [
                //Predio////
                // 'id_predio'          => $aportacion->getIdPredio()->getIdPredio(),
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
                'documentoPropiedad' => $aportacion->getIdPredio()->getDocumentoPropiedad(),
                'folio'              => $aportacion->getIdPredio()->getFolio(),
                'fechaDocumento'     => $aportacion->getIdPredio()->getFechaDocumento()->format('Y-m-d'),
                'loteConflicto'      => $aportacion->getIdPredio()->getLoteConflicto(),
                'observaciones'      => $aportacion->getIdPredio()->getObservaciones(),
                ///Contiribuyente//
                'idcontribuyente'    => $aportacion->getIdContribuyente()->getIdContribuyente(),
                'contribuyente'      => $aportacion->getIdContribuyente()->getNombre(),
                'factura'            => $aportacion->getIdContribuyente()->getFactura(),
                'giroComercial'      => $aportacion->getIdContribuyente()->getGiroComercial(),
                'nombreComercial'    => $aportacion->getIdContribuyente()->getNombreComercial(),
                'tenencia'           => $aportacion->getIdContribuyente()->getTenencia(),
                'rfContribuyente'                => $aportacion->getIdContribuyente()->getRfc(),
                'usoDestino'         => $aportacion->getIdContribuyente()->getUsoDestino(),
                ///Aportacion
                'vig'                   => $aportacion->getFecha()->format('Y-m-d'),
                'metrosTerreno'         => $aportacion->getMetrosTerreno(),
                'valorMZona'            => $aportacion->getValorZona(),
                'valorTerreno'          => $aportacion->getValorTerreno(),
                'metrosConstruccion'    => $aportacion->getMetrosConstruccion(),
                'valorMConstruccion'    => $aportacion->getValorMtsConstruccion(),
                'valorConstruccion'     => $aportacion->getValorConstruccion(),
                'ejercicioFiscal'       => $aportacion->getEjercicioFiscal(),
                'ejercicioFiscalFinal'  => $aportacion->getEjercicioFiscalFinal(),
                'avaluo'                => $aportacion->getAvaluo(),
                'tasa'                  => $aportacion->getTasa(),
                'pago'                  => $aportacion->getPago(),
            ];

            $view = new JsonModel($data);
        }
        return $view;
    }

    public function addContribuyenteAction()
    {
        $req_post = $this->params()->fromPost();

        if ($req_post['c'][0]['rfc'] == "XAXX010101000" ||$req_post['c'][0]['rfc'] == "XEXX010101000") {
            $result = $this->aportacionManager->guardarTest($req_post['c'][0]);

            if ($result) {
                $datos = ["resp"=>"ok", "msg"=>"cambios guardados", 'id_objeto' =>$result->getIdAportacion(), 'nombre' =>$result->getIdContribuyente()->getNombre(), 'rfc' =>$result->getIdContribuyente()->getRfc() ];
            } else {
                $datos = ["resp"=>"no", "msg"=>"No se guardo"];
            }
        } else {
            $rfc = $this->opergobserviceadapter->obtenerPersonaPorRfc($req_post['c'][0]['rfc']);


            if (isset($rfc->Persona)) {
                $datos = ["resp"=>"okno", "msg"=>"YA EXISTE ESA PERSONA"];
            } else {
                $result = $this->aportacionManager->guardarTest($req_post['c'][0]);

                if ($result) {
                    $datos = ["resp"=>"ok", "msg"=>"cambios guardados", 'id_objeto' =>$result->getIdAportacion(), 'nombre' =>$result->getIdContribuyente()->getNombre(), 'rfc' =>$result->getIdContribuyente()->getRfc() ];
                } else {
                    $datos = ["resp"=>"no", "msg"=>"No se guardo"];
                }
            }
        }

        $json = new JsonModel($datos);
        $json->setTerminal(true);

        return $json;
    }


    public function updateAportacionAction()
    {
        $req_post = $this->params()->fromPost();

        $result = $this->aportacionManager->guardarAportacion($req_post['a'][0]);

        $datos = ["resp"=>"ok", "msg"=>"cambios guardados"];

        $json = new JsonModel($datos);
        $json->setTerminal(true);

        return $json;
    }



    public function addAportacionAction()
    {
        $req_post = $this->params()->fromPost();

        $result = $this->aportacionManager->guardarAportacion($req_post['a'][0]);

        $datos = ["resp"=>"ok", "msg"=>"se guardo correctamente"];

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

            if ($result) {
                $datos = ["resp"=>"ok", "msg"=>"cambios guardados", 'id_objeto' =>$result->getIdAportacion(), 'id_predio' =>$result->getIdPredio()->getIdPredio()];
            } else {
                $datos = ["resp"=>"no", "msg"=>"No se guardo"];
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
        $colindancia = $predioColindancias->getPuntoCardinal();
        $this->aportacionManager->eliminarColindancias($predioColindancias);

        $datos = ["resp"=>"ok", "msg"=>"se elimino correctamente", 'return_valorColindancia' => $colindancia];

        $json = new JsonModel($datos);
        $json->setTerminal(true);

        return $json;
    }
    ///////////Editar Datatbale Colindancias/////////
    public function editColindanciaAction()
    {
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
    public function updateColindanciasAction()
    {
        $req_post = $this->params()->fromPost();

        $result = $this->aportacionManager->actualizarColindancias($req_post['c'][0]);


        $datos = ["resp"=>"ok", "msg"=>"se actualizo correctamente"];

        $json = new JsonModel($datos);
        $json->setTerminal(true);

        return $json;
    }

    public function statusValidationAction()
    {
        $req_post = $this->params()->fromPost();
        $aportacion = $this->entityManager->getRepository(Aportacion::class)->findOneByIdAportacion($req_post['a'][0]['id']);
        $Idcontribuyente = $aportacion->getIdContribuyente()->getIdContribuyente();
        $contribuyente = $this->entityManager->getRepository(Contribuyente::class)->findOneByIdContribuyente($Idcontribuyente);
        if ($req_post['a'][0]['status'] == 1) {
            $status = $req_post['a'][0]['status'];
            $this->aportacionManager->update($contribuyente, $aportacion, $status);
            $datos = ["resp"=>"ok", "msg"=>"se Confirmo Correctamente"];
        } elseif ($req_post['a'][0]['status'] == 2) {
            $status = $req_post['a'][0]['status'];
            $this->aportacionManager->update($contribuyente, $aportacion, $status);
            $datos = ["resp"=>"ok", "msg"=>"se Cancelo Correctamente"];
        } else {
            $datos = ["resp"=>"no", "msg"=>"Error"];
        }



        $json = new JsonModel($datos);
        $json->setTerminal(true);

        return $json;
    }
}
