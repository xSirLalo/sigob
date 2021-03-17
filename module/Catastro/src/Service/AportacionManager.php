<?php

namespace Catastro\Service;

use Catastro\Entity\Predio;
use Catastro\Entity\PredioColindancia;
use Catastro\Entity\Aportacion;
use Catastro\Entity\Contribuyente;
use Catastro\Model\Backend\OperGobServiceAdapter;

class AportacionManager
{
    /**
     * Entity manager.
     * @var Doctrine\ORM\EntityManager;
     */
    private $entityManager;
    private $opergobserviceadapter;
    /**
     * Constructor.
     */
    public function __construct($entityManager, $opergobserviceadapter)
    {
        $this->entityManager = $entityManager;
        $this->opergobserviceadapter = $opergobserviceadapter;
    }

    public function guardarModal($data)
    {
        $aportacion = new Aportacion();
        $predio = new Predio();

        $contribuyentebd = $this->entityManager->getRepository(Contribuyente::class)->findOneByIdContribuyente($data['idcontribuyente']);
        $aportacion->setIdContribuyente($contribuyentebd);
        $prediobd = $this->entityManager->getRepository(Predio::class)->findOneByIdPredio($data['id_predio']);
        $aportacion->setIdPredio($prediobd);
        $aportacion->setPago($data['pago_a']);
        $fecha = new \DateTime($data['vig']);
        $aportacion->setFecha($fecha);
        $aportacion->setMetrosTerreno($data['terreno']);
        $aportacion->setMetrosConstruccion($data['sup_m']);
        $aportacion->setValorTerreno($data['v_terreno']);
        $aportacion->setValorConstruccion($data['v_c']);
        $aportacion->setAvaluo($data['a_total']);
        $aportacion->setEstatus($data['status']);

        $currentDate = new \DateTime();
        $aportacion->setCreatedAt($currentDate);
        $aportacion->setUpdatedAt($currentDate);

        $this->entityManager->persist($aportacion);
        $this->entityManager->flush();
    }

    public function guardar($data)
    {
        $aportacion = new Aportacion();
        $predio = new Predio();

        $cvepredio  = $data['cvepredio'];
        $idcontribuyente = $data['parametro'];

        $contribuyentebd = $this->entityManager->getRepository(Contribuyente::class)->findOneByIdContribuyente($idcontribuyente);
        $predio->setIdContribuyente($contribuyentebd);
        $predio->setClaveCatastral($data['contribuyente_id']);
        $predio->setUbicacion($data['ubicacion']);
        $predio->setTitular($data['titular']);
        $predio->setTitularAnterior($data['titular_anterior']);
        $predio->setCvePredio($cvepredio);

        $this->entityManager->persist($predio);
        $this->entityManager->flush();

        $contribuyentebd = $this->entityManager->getRepository(Contribuyente::class)->findOneByIdContribuyente($idcontribuyente);
        $prediobd = $this->entityManager->getRepository(Predio::class)->findOneByCvePredio($cvepredio);
        $aportacion->setIdContribuyente($contribuyentebd);
        $aportacion->setIdPredio($prediobd);
        $aportacion->setPago($data['pago_a']);//Pago aportacion
        $aportacion->setAvaluo($data['a_total']);//Avaluo Total
        $aportacion ->setEstatus($data['status']);//Estatus
        $fecha = new \DateTime($data['vig']);//fecha
        $aportacion->setFecha($fecha);
        $aportacion ->setMetrosTerreno($data['terreno']);//Metros2 Terrreno
        $aportacion ->setMetrosConstruccion($data['sup_m']);//Metros2 Metros2 Construccion
        $aportacion ->setValorTerreno($data['v_terreno']);//Valor terreno
        $aportacion ->setValorConstruccion($data['v_c']);//Valor Construccion

        $this->entityManager->persist($aportacion);
        $this->entityManager->flush();

        $prediosColindaciasWeb = $this->opergobserviceadapter->obtenerColindancia($cvepredio);
        $prediobd = $this->entityManager->getRepository(Predio::class)->findOneByCvePredio($cvepredio);
        ///////////////////
        // $arreglo = [];
        // foreach($prediosColindaciasWeb->PredioColindancia as $item)
        // {
        //     $predioColindacia = new PredioColindancia();
        //     $arreglo = [
        //         'descripcion' => $item->Descripcion,
        //         'medidasmts' => $item->MedidasMts,
        //         'Orientaciongeografica' => $item->OrientacionGeografica,
        //     ];
        //     $predioColindacia->setIdPredio($prediobd);
        //     $predioColindacia->setDescripcion($arreglo['descripcion']);
        //     $predioColindacia->setMedidaMetros($arreglo['medidasmts']);
        //     $predioColindacia->setOrientacionGeografica($arreglo['Orientaciongeografica']);
        //     $this->entityManager->persist($predioColindacia);
        // }
        ///////////////////
        foreach ($prediosColindaciasWeb->PredioColindancia as $item) {
            $predioColindacia = new PredioColindancia();
            $predioColindacia->setIdPredio($prediobd);
            $predioColindacia->setDescripcion($item->Descripcion);
            $predioColindacia->setMedidaMetros($item->MedidaMts);
            $predioColindacia->setOrientacionGeografica($item->OrientacionGeografica);
            $this->entityManager->persist($predioColindacia);
        }
        $this->entityManager->flush();

        if ($aportacion->getIdAportacion() > 0) {
            return $aportacion;
        }
        return null;
    }
    public function guardarPersona($data)
    {
        $contribuyente = new Contribuyente();

        $contribuyente->setApellidoPaterno($data['apellido_paterno']);
        $contribuyente->setApellidoMaterno($data['apellido_materno']);
        $contribuyente->setCurp($data['curp']);
        $contribuyente->setCvePersona($data['cve_persona']);
        $contribuyente->setGenero($data['genero']);
        $contribuyente->setNombre($data['nombre']);
        $contribuyente->setTelefono($data['telefono']);
        $contribuyente->setCorreo($data['correo']);
        $contribuyente->setRfc($data['rfc']);
        $contribuyente->getRazonSocial($data['razon_social']);

        $currentDate = new \DateTime();
        $contribuyente->setCreatedAt($currentDate);
        $contribuyente->setUpdatedAt($currentDate);

        $this->entityManager->persist($contribuyente);
        $this->entityManager->flush();
        if ($contribuyente->getIdContribuyente() > 0) {
            return $contribuyente;
        }
        return null;
    }

    public function pdf($aportacion)
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
        $aportacion = $this->entityManager->getRepository(Aportacion::class)->findOneByIdAportacion($aportacion);
        $predio = $this->entityManager->getRepository(Predio::class)->findOneByIdPredio($aportacion->getIdPredio());

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

        // ///Formato para las fechas
        // $fecha_adquicision = date("d-m-Y", strtotime($data['fecha_adquisicion']));
        // $fecha = date("d-m-Y", strtotime($data['vig']));
        // ///formato de numeros
        // $text = '<h6><font size="5"><br>EL CALCULO DE LA APORTACION QUE AMPARA ESTE DOCUMNTO, SE HACE A PETICION DEL SOLICITANTE Y EN NINGUN CASO SE CONSIDERA COMO PAGO DE IMPUESTO PREDIAL. ESTE DOCUMENTO NO CONSTITUYE UNA CEDULA , Y  POR TANTO, NO SE  RECONOCE COMO DERECHOS DE PROPIEDAD SOBRE EL INMUEBLE. LA VIGENCIA DE ESTA TARJETA DE IDENTIFICACION ES ANUAL.</font><h6>';
        // ///No remover o todo se vuelve negro
        $pdf->MultiCell(10, 5, '', 1, 'C', 1, 0, '280', '', true);
        // ///No remover o todo se vuelve negro
        //N.Region
        $region = $predio->getClaveCatastral();
        //Lote o Parcela
        $lote = $predio->getClaveCatastral();

        // ////////////////CABEZERA Y IMAGENES DEL FORMATO//////////////////
        $pdf->Image('public/img/tulum.png', 23, 20, 30, 30, 'PNG', '', '', true, 150, '', false, false, 0, false, false, false);
        $pdf->MultiCell(58, 30, '<h5><font size="11">H.AYUNTAMIENTO DE TULUM<br>TESORERIA MUNICIPAL<br>DIRECCION DE CATASTRO</font></h5>', 0, 'C', 1, 0, '75', '', true, 0, true);
        $pdf->Image('public/img/logo.png', 158, 20, 30, 30, 'PNG', '', '', true, 150, '', false, false, 0, false, false, false);
        // ///////////////INICIO DE TABLA/////////////////
        $pdf->MultiCell(40, 12, '<h6><font size="8">TARJETA DE APORTACION</font></h6>', 1, 'C', 1, 0, '17', '65', true, 0, true);
        $pdf->MultiCell(30, 12, '<h6><font size="8">No. REGION</font></h6><h6><font size="7">'.substr($region, 9, -8).'</font></h6>', 1, 'C', 1, 0, '', '', true, 0, true);
        $pdf->MultiCell(30, 12, '<h6><font size="8">LOTE o PARCELA</font></h6><h6><font size="7">'.substr($lote, 16).'</font></h6>', 1, 'C', 1, 0, '', '', true, 0, true);
        // $pdf->MultiCell(37, 12, '<h6><font size="8">CATEGORIA</font></h6><h6><font size="7">' . $data['categoria'] . '</font></h6>', 1, 'C', 1, 0, '', '', true, 0, true);
        // $pdf->MultiCell(39, 12, '<h6><font size="8">CONDICION</font></h6><h6><font size="7">' . $data['condicion'] . '</font></h6>', 1, 'C', 1, 0, '', '', true, 0, true);
        // $pdf->Ln(11.5);
        // $pdf->writeHTMLCell(0, 0, '', '', $tabla, 0, 1, 0, true, '', true);
        // // ////////////DATOS DEL POSECIONARIO//////////////
        // $pdf->MultiCell(58.66, 12, '<h6><font size="8">TITULAR</font></h6><h6><font size="7">' . $data['titular'] . '</font></h6>', 1, 'C', 1, 0, '17', '86', true, 0, true);
        // $pdf->MultiCell(58.66, 12, '<h6><font size="8">UBICACIÓN</font></h6><h6><font size="7">' . $data['ubicacion'] . '</font></h6>', 1, 'C', 1, 0, '', '', true, 0, true);
        // $pdf->MultiCell(58.66, 12, '<h6><font size="8">LOCALIDAD</font></h6><h6><font size="7">' . $data['localidad'] . '</font></h6>', 1, 'C', 1, 0, '', '', true, 0, true);
        // $pdf->MultiCell(58.66, 12, '<h6><font size="8">DOCUMENTO QUE ACREDITE LA PROPIEDAD</font></h6><h6><font size="7">' . $data['d_propiedad'] . '</font></h6>', 1, 'C', 1, 0, '17', '98', true, 0, true);
        // //$pdf->MultiCell(117.32, 41.4, 'MEDIDAS Y COLINDANCIAS\n\nAl Norte: 50 Con: Calle 51\nAl Sur: 50 Con:Calle 52\nAl Este: 50 Con:Calle 53\nAl Oeste: 50 Con:Calle 54', 1, 'C', 1, 0, '', '', true);
        // $pdf->MultiCell(117.32, 35, '<h6><font size="9">MEDIDAS Y COLINDACIAS</font></h6><br><h6><font size="9">Al Norte:' . $data['norte'] . ' Con:' . $data['con_norte'] . '</font></h6><br><h6><font size="9">Al Sur:' . $data['sur'] . ' Con:' . $data['con_sur'] . '</font></h6><br><h6><font size="9">Al Este:' . $data['este'] . ' Con:' . $data['con_este'] . '</font></h6><br><h6><font size="9">Al Oeste:' . $data['oeste'] . ' Con:' . $data['con_oeste'] . '</font></h6>', 1, 'C', 1, 0, '', '', true, 0, true);
        // $pdf->MultiCell(58.66, 20, '<h6><font size="9">ARRENDADOR</font></h6><h6><font size="7">' . $data['arrendador'] . '</font></h6>', 1, 'C', 1, 0, '17', '113', true, 0, true);
        // $pdf->MultiCell(58.66, 12, '<h6><font size="7">DOCUMENTO DE ARRENDAMIETO O POSESION</font></h6><h6><font size="7">' . $data['d_arrendamiento'] . '</font></h6>', 1, 'C', 1, 0, '17', '133', true, 0, true);
        // $pdf->MultiCell(58.66, 14.8, '<h6><font size="9">FECHA DE ADQUISICION</font></h6><h6><font size="7">' . $fecha_adquicision . '</font></h6>', 1, 'C', 1, 0, '', '', true, 0, true);
        // $pdf->MultiCell(58.66, 14.8, '<h6><font size="9">TITULAR ANTERIOR</font></h6><h6><font size="7">' . $data['titular_anterior'] . '</font></h6>', 1, 'C', 1, 0, '', '', true, 0, true);
        // // ////////////DATOS DEL INMUEBLE//////////////
        // $pdf->Ln(14.4);
        // $pdf->writeHTMLCell(0, 0, '', '', $tabla2, 0, 1, 0, true, '', true);
        // $pdf->MultiCell(87.99, 12, '<h6><font size="8">GIRO COMERCIAL</font></h6><h6><font size="7">' . $data['g_comercial'] . '</font></h6>', 1, 'C', 1, 0, '17', '157', true, 0, true);
        // $pdf->MultiCell(87.99, 12, '<h6><font size="8">NOMBRE COMERCIAL</font></h6><h6><font size="7">' . $data['n_comercial'] . '</font></h6>', 1, 'C', 1, 0, '', '', true, 0, true);
        // $pdf->MultiCell(87.99, 12, '<h6><font size="8">SUPERFICIE OCUPADA</font></h6><h6><font size="7">' . $data['s_ocupada'] . '</font></h6>', 1, 'C', 1, 0, '17', '169', true, 0, true);
        // $pdf->MultiCell(87.98, 12, '<h6><font size="8">USO O DESTINO</font></h6><h6><font size="7">' . $data['u_destino'] . '</font></h6>', 1, 'C', 1, 0, '', '', true, 0, true);
        // // ////////////DATOS DE POSSESION//////////////
        // $pdf->Ln(11.6);
        // $pdf->writeHTMLCell(0, 0, '', '', $tabla3, 0, 1, 0, true, '', true);
        // $pdf->MultiCell(40, 14.8, '<h6><font size="7">SUP.M2 TERRENO</font></h6><h6><font size="7">' . $data['terreno'] . '</font></h6>', 1, 'C', 1, 0, '17', '190', true, 0, true);
        // $pdf->MultiCell(30, 12, '<h6><font size="7">VALOR DEL TERRENO</font></h6><h6><font size="7">$' . $data['v_terreno'] . '</font></h6>', 1, 'C', 1, 0, '', '', true, 0, true);
        // $pdf->MultiCell(30, 12, '<h6><font size="7">SUP. M2 CONSTRUCCION</font></h6><h6><font size="7">' . $data['sup_m'] . '</font></h6>', 1, 'C', 1, 0, '', '', true, 0, true);
        // $pdf->MultiCell(37, 12, '<h6><font size="7">VALOR DE LA CONSTRUCCION</font></h6><h6><font size="7">$' . $data['v_c'] . '</font></h6>', 1, 'C', 1, 0, '', '', true, 0, true);
        // $pdf->MultiCell(39, 14.8, '<h6><font size="7">AVALUO TOTAL</font></h6><h6><font size="7">$' . $data['a_total'] . '</font></h6>', 1, 'C', 1, 0, '', '', true, 0, true);
        // $pdf->MultiCell(44, 12, '<h6><font size="8">FECHA</font></h6><h6><font size="7">' . $fecha . '</font></h6>', 1, 'C', 1, 0, '17', '204.9', true, 0, true);
        // // $pdf->MultiCell(44, 12, '<h6><font size="8">TASA IMPOSITIVA</font></h6><h6><font size="7">' . $data['validation-select'] . '</font></h6>', 1, 'C', 1, 0, '', '', true, 0, true);
        // $pdf->MultiCell(44, 12, '<h6><font size="8">EJERCICIO FISCAL</font></h6><h6><font size="7">' . $data['ejercicio_f'] . '</font></h6>', 1, 'C', 1, 0, '', '', true, 0, true);
        // $pdf->MultiCell(44, 12, '<h6><font size="8">PAGO DE APORTACION</font></h6><h6><font size="7">$' . $data['pago_a'] . '</font></h6>', 1, 'C', 1, 0, '', '', true, 0, true);
        // // ////////////Final de la tabla//////////////
        // $pdf->Ln(11.6);
        // $pdf->writeHTMLCell(0, 0, '', '', $tabla4, 0, 1, 0, true, '', true);
        // $pdf->MultiCell(176, 15, '' . $text, 1, 'C', 1, 0, '17', '226.2', true, 0, true);
        // $pdf->Ln(25);
        // $pdf->MultiCell(58.66, 12, '<h6><font size="8">_____________________<br>ELABORO</font></h6>', 0, 'C', 1, 0, '17', '', true, 0, true);
        // $pdf->MultiCell(58.66, 12, '<h6><font size="8">_____________________<br>JEFE DE DEPTO</font></h6>', 0, 'C', 1, 0, '', '', true, 0, true);
        // $pdf->MultiCell(58.66, 12, '<h6><font size="8">_____________________<br>DIRECTOR</font></h6>', 0, 'C', 1, 0, '', '', true, 0, true);

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

    public function update($aportacion, $datos)
    {
        $aportacion->setEstatus($datos['status']);

        $this->entityManager->flush();
    }

    public function actualizar($aportacion, $data)
    {
        $aportacion->setPago($data['pago']);

        $currentDate = new \DateTime();
        $aportacion->setUpdatedAt($currentDate);

        $this->entityManager->flush();
    }

    public function eliminar($aportacion)
    {
        $this->entityManager->remove($aportacion);

        $this->entityManager->flush();
    }
}
