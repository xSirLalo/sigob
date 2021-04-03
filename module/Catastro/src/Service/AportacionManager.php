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

    // public function guardar($contribuyente, $data)
    public function guardar($data)
    {
        $aportacion = new Aportacion();
        $predio = new Predio();

        // $contribuyente->setRfc($data['rfc']);
        // $this->entityManager->flush();

        // $cvepredio  = $data['cvepredio'];
        $idcontribuyente = $data['parametro'];

        ///Guarda el Predio///
        $contribuyentebd = $this->entityManager->getRepository(Contribuyente::class)->findOneByIdContribuyente($idcontribuyente);

        $predio->setIdContribuyente($contribuyentebd);
        $predio->setParcela($data['parcela']);
        $predio->setManzana($data['manzana']);
        $predio->setLote($data['lote']);
        $predio->setLocal($data['local']);
        $predio->setCategoria($data['categoria']);
        $predio->setCondicion($data['condicion']);
        $predio->setTitular($data['titular']);
        $predio->setUbicacion($data['ubicacion']);
        $predio->setLocalidad($data['localidad']);
        $predio->setAntecedentes($data['antecedentes']);
        $predio->setClaveCatastral($data['clave_catastral']);
        $predio->setRegimenPropiedad($data['regimen_propiedad']);
        $fecha_adquicision = new \DateTime($data['fecha_adquisicion']);
        $predio->setFechaAdquicision($fecha_adquicision);
        $predio->setTitularAnterior($data['titular_anterior']);

        $this->entityManager->persist($predio);
        $this->entityManager->flush();

        ///Guarda el Predio Colindacias///
        $prediobd = $this->entityManager->getRepository(Predio::class)->findOneByIdContribuyente($idcontribuyente);
        $predioColindacia = new PredioColindancia();
        $predioColindacia->setIdPredio($prediobd);
        $predioColindacia->setDescripcion($data['con_norte']);
        $predioColindacia->setMedidaMetros($data['norte']);
        $predioColindacia->setOrientacionGeografica("N");
        $this->entityManager->persist($predioColindacia);
        $this->entityManager->flush();

        $prediobd = $this->entityManager->getRepository(Predio::class)->findOneByIdContribuyente($idcontribuyente);
        $predioColindacia = new PredioColindancia();
        $predioColindacia->setIdPredio($prediobd);
        $predioColindacia->setDescripcion($data['con_sur']);
        $predioColindacia->setMedidaMetros($data['sur']);
        $predioColindacia->setOrientacionGeografica("S");
        $this->entityManager->persist($predioColindacia);
        $this->entityManager->flush();

        $prediobd = $this->entityManager->getRepository(Predio::class)->findOneByIdContribuyente($idcontribuyente);
        $predioColindacia = new PredioColindancia();
        $predioColindacia->setIdPredio($prediobd);
        $predioColindacia->setDescripcion($data['con_este']);
        $predioColindacia->setMedidaMetros($data['este']);
        $predioColindacia->setOrientacionGeografica("E");
        $this->entityManager->persist($predioColindacia);
        $this->entityManager->flush();

        $prediobd = $this->entityManager->getRepository(Predio::class)->findOneByIdContribuyente($idcontribuyente);
        $predioColindacia = new PredioColindancia();
        $predioColindacia->setIdPredio($prediobd);
        $predioColindacia->setDescripcion($data['con_oeste']);
        $predioColindacia->setMedidaMetros($data['oeste']);
        $predioColindacia->setOrientacionGeografica("O");
        $this->entityManager->persist($predioColindacia);
        $this->entityManager->flush();

        ///Guarda la Aportacion///
        $contribuyentebd = $this->entityManager->getRepository(Contribuyente::class)->findOneByIdContribuyente($idcontribuyente);
        $prediobd = $this->entityManager->getRepository(Predio::class)->findOneByIdContribuyente($idcontribuyente);

        $aportacion->setIdContribuyente($contribuyentebd);
        $aportacion->setIdPredio($prediobd);
        $aportacion ->setEstatus($data['status']);//Estatus
        $fecha = new \DateTime($data['vig']);//fecha
        $aportacion->setFecha($fecha);
        $aportacion->setMetrosTerreno($data['terreno']);//Metros2 Terrreno
        $aportacion->setValorZona($data['valor_m2_zona']);//Valor Zona
        $valor_terreno = $data['terreno'] * $data['valor_m2_zona'];
        $aportacion->setValorTerreno($valor_terreno);//Valor terreno
        $aportacion->setMetrosConstruccion($data['sup_m']);//Metros2 Metros2 Construccion
        $aportacion->setValorMtsConstruccion($data['valor']);//VALOR M2 CONSTRUCCION
        $valor_construnccion = $data['sup_m']*$data['valor'];
        $aportacion->setValorConstruccion($valor_construnccion);//Valor Construccion
        $avaluo = $valor_terreno + $valor_construnccion;
        $aportacion->setAvaluo($avaluo);//Avaluo Total
        $aportacion->setTasa($data['tasa_hidden']);
        $aportacion->setEjercicioFiscal($data['ejercicio_f']);
        $pago_aportacion = $data['tasa_hidden']*$avaluo;
        $aportacion->setPago($pago_aportacion);//Pago aportacion

        $this->entityManager->persist($aportacion);
        $this->entityManager->flush();
        if ($aportacion->getIdAportacion() > 0) {
            return $aportacion;
        }

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

    public function actualizarContribuyente($contribuyente, $data)
    {

        $contribuyente->setNombre($data['contribuyente']);
        $contribuyente->setFactura($data['factura']);
        $contribuyente->setGiroComercial($data['giro_comercial']);
        $contribuyente->setNombreComercial($data['nombre_comercial']);
        $contribuyente->setTenencia($data['tenencia']);
        $contribuyente->setRfc($data['rfc']);
        $contribuyente->setUsoDestino($data['uso_destino']);

        // $currentDate = new \DateTime();
        // $contribuyente->setUpdatedAt($currentDate);

        $this->entityManager->flush();
    }

    public function pdf($data,$aportacion)
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

        $contribuyenteId = $data['parametro'];

        // Valida que el parametro exista si no devuelve 404 no encontrado
        if ($contribuyenteId  < 0) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
        // Encuentra el id del dato consultado
        $contribuyente = $this->entityManager->getRepository(Contribuyente::class)->findOneByIdContribuyente($contribuyenteId);
        $predio = $this->entityManager->getRepository(Predio::class)->findOneByIdContribuyente($contribuyenteId);
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
                    <th rowspan="4" colspan ="2">'.$predio->getAntecedentes().'</th>
                    <th>AL NORTE:</th>
                    <th><font size="7">'.$medidas[0].'</font></th>
                    <th>CON:</th>
                    <th><font size="7">'.$descripcion[0].'</font></th>
                </tr>
                <tr>
                    <th>AL SUR:</th>
                    <th><font size="7">'.$medidas[1].'</font></th>
                    <th>CON:</th>
                    <th><font size="7">'.$descripcion[1].'</font></th>
                </tr>
                <tr>
                    <th>AL ESTE:</th>
                    <th><font size="7">'.$medidas[2].'</font></th>
                    <th>CON:</th>
                    <th><font size="7">'.$descripcion[2].'</font></th>
                </tr>
                <tr>
                    <th>AL OESTE</th>
                    <th>'.$medidas[3].'</th>
                    <th>CON:</th>
                    <th><font size="7">'.$descripcion[3].'</font></th>
                </tr>
                <tr style="background-color:#47A7AC;color:black;">
                <th colspan ="2">REGIMEN DE PROPIEDAD</th>
                <th colspan ="2">FECHA DE ADQUISICIÓN</th>
                <th colspan ="2">TITULAR ANTERIOR</th>
                </tr>
                <tr>
                    <th colspan ="2">'.$predio->getRegimenPropiedad().'<font size="7"></font></th>
                    <th colspan ="2">'.$predio->getFechaAdquicision()->format('d-m-Y').'<font size="7"></font></th>
                    <th colspan ="2">'.$predio->getTitularAnterior().'<font size="7"></font></th>
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
                    <th colspan ="2"><font size="7">$'.number_format($aportacion->getValorZona(),4).'</font></th>
                    <th colspan ="2"><font size="7">$'.number_format($aportacion->getValorTerreno(),4).'</font></th>
                </tr>
                <tr style="background-color:#47A7AC;color:black;">
                <th colspan ="2">SUP.M2 CONSTRUCCIÓN</th>
                <th colspan ="2">VALOR M2 CONSTRUCCION</th>
                <th colspan ="2">VALOR DE LA CONSTRUCCION</th>
                </tr>
                <tr>
                    <th colspan ="2"><font size="7">'.$aportacion->getMetrosConstruccion().'</font></th>
                    <th colspan ="2"><font size="7">$'.number_format($aportacion->getValorMtsConstruccion(),4).'</font></th>
                    <th colspan ="2"><font size="7">$'.number_format($aportacion->getValorConstruccion(),4).'</font></th>
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
                    <th><font size="7">'.number_format($aportacion->getTasa(),6).'</font></th>
                    <th colspan ="2"><font size="7">'.$aportacion->getEjercicioFiscal().'</font></th>
                    <th><font size="7">$'.number_format($aportacion->getPago(),4).'</font></th>
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
        return $this->redirect()->toRoute('aportacion');
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
     public function actualizarValidation($aportacion, $data)
    {
        $aportacion->setPago($data['pago_a']);
        $aportacion->setMetrosTerreno($data['terreno']);
        // $aportacion->setNombre($data['nombre']);
        // $aportacion->setApellidoPaterno($data['apellido_paterno']);
        // $aportacion->setApellidoMaterno($data['apellido_materno']);
        // $aportacion->setRfc($data['rfc']);
        // $aportacion->setCurp($data['curp']);
        // $aportacion->setGenero($data['genero']);

        // $currentDate = new \DateTime();
        // $aportacion->setUpdatedAt($currentDate);

        $this->entityManager->flush();
    }
}
