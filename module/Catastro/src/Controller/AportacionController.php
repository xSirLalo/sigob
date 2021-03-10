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
                $this->flashMessenger()->addSuccessMessage('Se agrego con éxito!');
                return $this->redirect()->toRoute('aportacion');
            }
        }
        return new ViewModel(['form' => $form, 'id' => $parametro, 'valorConstruccions' => $valorConstruccion]);
    }

    public function pdf()
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
        $tabla = '<table  cellspacing="3" cellpadding="4">
                <tr>
                <td  bgcolor="#cccccc" align="center" colspan="12">DATOS DE POSSESION</td>
                </tr>
                </table>';
        $tabla2 = '<table  cellspacing="3" cellpadding="4">
                <tr>
                <td  bgcolor="#cccccc" align="center" colspan="12">DATOS DEL INMUEBLE</td>
                </tr>
                </table>';
        $tabla3 = '<table  cellspacing="3" cellpadding="4">
                <tr>
                <td  bgcolor="#cccccc" align="center" colspan="12">DATOS  DE POSSESION</td>
                </tr>
                </table>';
        $tabla4 = '<table  cellspacing="3" cellpadding="4">
                <tr>
                <td  bgcolor="#cccccc" align="center" colspan="12"></td>
                </tr>
                </table>';

        ///Formato para las fechas
        $fecha_adquicision = date("d-m-Y", strtotime($data['fecha_adquisicion']));
        $fecha = date("d-m-Y", strtotime($data['vig']));
        ///formato de numeros
        $text = '<h6><font size="5"><br>EL CALCULO DE LA APORTACION QUE AMPARA ESTE DOCUMNTO, SE HACE A PETICION DEL SOLICITANTE Y EN NINGUN CASO SE CONSIDERA COMO PAGO DE IMPUESTO PREDIAL. ESTE DOCUMENTO NO CONSTITUYE UNA CEDULA , Y  POR TANTO, NO SE  RECONOCE COMO DERECHOS DE PROPIEDAD SOBRE EL INMUEBLE. LA VIGENCIA DE ESTA TARJETA DE IDENTIFICACION ES ANUAL.</font><h6>';
        ///No remover o todo se vuelve negro
        $pdf->MultiCell(10, 5, '', 1, 'C', 1, 0, '280', '', true);
        ///No remover o todo se vuelve negro

        ////////////////CABEZERA Y IMAGENES DEL FORMATO//////////////////
        $pdf->Image('public/img/tulum.png', 23, 20, 30, 30, 'PNG', '', '', true, 150, '', false, false, 0, false, false, false);
        $pdf->MultiCell(58, 30, '<h5><font size="11">H.AYUNTAMIENTO DE TULUM<br>TESORERIA MUNICIPAL<br>DIRECCION DE CATASTRO</font></h5>', 0, 'C', 1, 0, '75', '', true, 0, true);
        $pdf->Image('public/img/logo.png', 158, 20, 30, 30, 'PNG', '', '', true, 150, '', false, false, 0, false, false, false);
        ///////////////INICIO DE TABLA/////////////////
        $pdf->MultiCell(40, 12, '<h6><font size="8">TARJETA DE APORTACION</font></h6>', 1, 'C', 1, 0, '17', '65', true, 0, true);
        $pdf->MultiCell(30, 12, '<h6><font size="8">No. REGION</font></h6><h6><font size="7">-</font></h6>', 1, 'C', 1, 0, '', '', true, 0, true);
        $pdf->MultiCell(30, 12, '<h6><font size="8">LOTE o PARCELA</font></h6><h6><font size="7">-</font></h6>', 1, 'C', 1, 0, '', '', true, 0, true);
        $pdf->MultiCell(37, 12, '<h6><font size="8">CATEGORIA</font></h6><h6><font size="7">' . $data['categoria'] . '</font></h6>', 1, 'C', 1, 0, '', '', true, 0, true);
        $pdf->MultiCell(39, 12, '<h6><font size="8">CONDICION</font></h6><h6><font size="7">' . $data['condicion'] . '</font></h6>', 1, 'C', 1, 0, '', '', true, 0, true);
        $pdf->Ln(11.5);
        $pdf->writeHTMLCell(0, 0, '', '', $tabla, 0, 1, 0, true, '', true);
        // ////////////DATOS DEL POSECIONARIO//////////////
        $pdf->MultiCell(58.66, 12, '<h6><font size="8">TITULAR</font></h6><h6><font size="7">' . $data['titular'] . '</font></h6>', 1, 'C', 1, 0, '17', '86', true, 0, true);
        $pdf->MultiCell(58.66, 12, '<h6><font size="8">UBICACIÓN</font></h6><h6><font size="7">' . $data['ubicacion'] . '</font></h6>', 1, 'C', 1, 0, '', '', true, 0, true);
        $pdf->MultiCell(58.66, 12, '<h6><font size="8">LOCALIDAD</font></h6><h6><font size="7">' . $data['localidad'] . '</font></h6>', 1, 'C', 1, 0, '', '', true, 0, true);
        $pdf->MultiCell(58.66, 12, '<h6><font size="8">DOCUMENTO QUE ACREDITE LA PROPIEDAD</font></h6><h6><font size="7">' . $data['d_propiedad'] . '</font></h6>', 1, 'C', 1, 0, '17', '98', true, 0, true);
        //$pdf->MultiCell(117.32, 41.4, 'MEDIDAS Y COLINDANCIAS\n\nAl Norte: 50 Con: Calle 51\nAl Sur: 50 Con:Calle 52\nAl Este: 50 Con:Calle 53\nAl Oeste: 50 Con:Calle 54', 1, 'C', 1, 0, '', '', true);
        $pdf->MultiCell(117.32, 35, '<h6><font size="9">MEDIDAS Y COLINDACIAS</font></h6><br><h6><font size="9">Al Norte:' . $data['norte'] . ' Con:' . $data['con_norte'] . '</font></h6><br><h6><font size="9">Al Sur:' . $data['sur'] . ' Con:' . $data['con_sur'] . '</font></h6><br><h6><font size="9">Al Este:' . $data['este'] . ' Con:' . $data['con_este'] . '</font></h6><br><h6><font size="9">Al Oeste:' . $data['oeste'] . ' Con:' . $data['con_oeste'] . '</font></h6>', 1, 'C', 1, 0, '', '', true, 0, true);
        $pdf->MultiCell(58.66, 20, '<h6><font size="9">ARRENDADOR</font></h6><h6><font size="7">' . $data['arrendador'] . '</font></h6>', 1, 'C', 1, 0, '17', '113', true, 0, true);
        $pdf->MultiCell(58.66, 12, '<h6><font size="7">DOCUMENTO DE ARRENDAMIETO O POSESION</font></h6><h6><font size="7">' . $data['d_arrendamiento'] . '</font></h6>', 1, 'C', 1, 0, '17', '133', true, 0, true);
        $pdf->MultiCell(58.66, 14.8, '<h6><font size="9">FECHA DE ADQUISICION</font></h6><h6><font size="7">' . $fecha_adquicision . '</font></h6>', 1, 'C', 1, 0, '', '', true, 0, true);
        $pdf->MultiCell(58.66, 14.8, '<h6><font size="9">TITULAR ANTERIOR</font></h6><h6><font size="7">' . $data['titular_anterior'] . '</font></h6>', 1, 'C', 1, 0, '', '', true, 0, true);
        // ////////////DATOS DEL INMUEBLE//////////////
        $pdf->Ln(14.4);
        $pdf->writeHTMLCell(0, 0, '', '', $tabla2, 0, 1, 0, true, '', true);
        $pdf->MultiCell(87.99, 12, '<h6><font size="8">GIRO COMERCIAL</font></h6><h6><font size="7">' . $data['g_comercial'] . '</font></h6>', 1, 'C', 1, 0, '17', '157', true, 0, true);
        $pdf->MultiCell(87.99, 12, '<h6><font size="8">NOMBRE COMERCIAL</font></h6><h6><font size="7">' . $data['n_comercial'] . '</font></h6>', 1, 'C', 1, 0, '', '', true, 0, true);
        $pdf->MultiCell(87.99, 12, '<h6><font size="8">SUPERFICIE OCUPADA</font></h6><h6><font size="7">' . $data['s_ocupada'] . '</font></h6>', 1, 'C', 1, 0, '17', '169', true, 0, true);
        $pdf->MultiCell(87.98, 12, '<h6><font size="8">USO O DESTINO</font></h6><h6><font size="7">' . $data['u_destino'] . '</font></h6>', 1, 'C', 1, 0, '', '', true, 0, true);
        // ////////////DATOS DE POSSESION//////////////
        $pdf->Ln(11.6);
        $pdf->writeHTMLCell(0, 0, '', '', $tabla3, 0, 1, 0, true, '', true);
        $pdf->MultiCell(40, 14.8, '<h6><font size="7">SUP.M2 TERRENO</font></h6><h6><font size="7">' . $data['terreno'] . '</font></h6>', 1, 'C', 1, 0, '17', '190', true, 0, true);
        $pdf->MultiCell(30, 12, '<h6><font size="7">VALOR DEL TERRENO</font></h6><h6><font size="7">$' . $data['v_terreno'] . '</font></h6>', 1, 'C', 1, 0, '', '', true, 0, true);
        $pdf->MultiCell(30, 12, '<h6><font size="7">SUP. M2 CONSTRUCCION</font></h6><h6><font size="7">' . $data['sup_m'] . '</font></h6>', 1, 'C', 1, 0, '', '', true, 0, true);
        $pdf->MultiCell(37, 12, '<h6><font size="7">VALOR DE LA CONSTRUCCION</font></h6><h6><font size="7">$' . $data['v_c'] . '</font></h6>', 1, 'C', 1, 0, '', '', true, 0, true);
        $pdf->MultiCell(39, 14.8, '<h6><font size="7">AVALUO TOTAL</font></h6><h6><font size="7">$' . $data['a_total'] . '</font></h6>', 1, 'C', 1, 0, '', '', true, 0, true);
        $pdf->MultiCell(44, 12, '<h6><font size="8">FECHA</font></h6><h6><font size="7">' . $fecha . '</font></h6>', 1, 'C', 1, 0, '17', '204.9', true, 0, true);
        $pdf->MultiCell(44, 12, '<h6><font size="8">TASA IMPOSITIVA</font></h6><h6><font size="7">' . $data['validation-select'] . '</font></h6>', 1, 'C', 1, 0, '', '', true, 0, true);
        $pdf->MultiCell(44, 12, '<h6><font size="8">EJERCICIO FISCAL</font></h6><h6><font size="7">' . $data['ejercicio_f'] . '</font></h6>', 1, 'C', 1, 0, '', '', true, 0, true);
        $pdf->MultiCell(44, 12, '<h6><font size="8">PAGO DE APORTACION</font></h6><h6><font size="7">$' . $data['pago_a'] . '</font></h6>', 1, 'C', 1, 0, '', '', true, 0, true);
        // ////////////Final de la tabla//////////////
        $pdf->Ln(11.6);
        $pdf->writeHTMLCell(0, 0, '', '', $tabla4, 0, 1, 0, true, '', true);
        $pdf->MultiCell(176, 15, '' . $text, 1, 'C', 1, 0, '17', '226.2', true, 0, true);
        $pdf->Ln(25);
        $pdf->MultiCell(58.66, 12, '<h6><font size="8">_____________________<br>ELABORO</font></h6>', 0, 'C', 1, 0, '17', '', true, 0, true);
        $pdf->MultiCell(58.66, 12, '<h6><font size="8">_____________________<br>JEFE DE DEPTO</font></h6>', 0, 'C', 1, 0, '', '', true, 0, true);
        $pdf->MultiCell(58.66, 12, '<h6><font size="8">_____________________<br>DIRECTOR</font></h6>', 0, 'C', 1, 0, '', '', true, 0, true);

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
        return new ViewModel();
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
