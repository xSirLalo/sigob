<?php

namespace Catastro\Service;

use Catastro\Entity\Predio;
use Catastro\Entity\PredioColindancia;
use Catastro\Entity\Aportacion;
use Catastro\Entity\Contribuyente;
use Catastro\Entity\Localidad;
use Catastro\Entity\GiroComercial;
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
        $aportacion ->setEstatus($data['status']);//Estatus
        $fecha = new \DateTime($data['vig']);//fecha
        $aportacion->setFecha($fecha);
        $fecha_adquicision = new \DateTime($data['fecha_adquisicion']);
        $aportacion->setFechaAdquicision($fecha_adquicision);
        $aportacion->setObservaciones($data['observaciones']);
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
        $aportacion->setFactura($data['factura']);

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
        $fecha_adquicision = new \DateTime($data['fecha_adquisicion']);
        $aportacion->setFechaAdquicision($fecha_adquicision);
        $aportacion->setObservaciones($data['observaciones']);
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
        $aportacion->setFactura($data['factura']);

        $this->entityManager->persist($aportacion);
        $this->entityManager->flush();
        if ($aportacion->getIdAportacion() > 0) {
            return $aportacion;
        }

    }
    public function guardarPersona($data)
    {

            $contribuyente = new Contribuyente();
            //////Contribuyente/////
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

            return 0;

    }

    public function actualizarContribuyente($contribuyente, $data)
    {

        $contribuyente->setNombre($data['contribuyente']);
        // $contribuyente->setFactura($data['factura']);
        $contribuyente->setGiroComercial($data['giro_comercial']);
        $contribuyente->setNombreComercial($data['nombre_comercial']);
        $contribuyente->setTenencia($data['tenencia']);
        $contribuyente->setRfc($data['rfc']);
        $contribuyente->setUsoDestino($data['uso_destino']);

        // $currentDate = new \DateTime();
        // $contribuyente->setUpdatedAt($currentDate);

        $this->entityManager->flush();
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

        // $contribuyenteId = $data['parametro'];
        $contribuyenteId = $aportacion->getIdContribuyente()->getIdContribuyente();

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
                    <th rowspan="4" colspan ="2"><br><br><br><font size="7">'.$predio->getAntecedentes().'</font></th>
                    <th>AL NORTE:</th>
                    <th><font size="7"></font></th>
                    <th>CON:</th>
                    <th><font size="7"></font></th>
                </tr>
                <tr>
                    <th>AL SUR:</th>
                    <th><font size="7"></font></th>
                    <th>CON:</th>
                    <th><font size="7"></font></th>
                </tr>
                <tr>
                    <th>AL ESTE:</th>
                    <th><font size="7"></font></th>
                    <th>CON:</th>
                    <th><font size="7"></font></th>
                </tr>
                <tr>
                    <th>AL OESTE</th>
                    <th><font size="7"></font></th>
                    <th>CON:</th>
                    <th><font size="7"></font></th>
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

    public function update($contribuyente,$aportacion, $status)
    {
        if($status==1){
            $cvpersona  =  $aportacion->getIdContribuyente()->getCvePersona();
            if($cvpersona > 0){
                $cvpersona  =  $aportacion->getIdContribuyente()->getCvePersona();
            }else{
                $nombre              = $aportacion->getIdContribuyente()->getNombre();
                $apellido_paterno    = $aportacion->getIdContribuyente()->getApellidoPaterno();
                $apellido_materno    = $aportacion->getIdContribuyente()->getApellidoMaterno();
                // $genero              = $aportacion->getIdContribuyente()->get();
                $genero              = "H";
                // $estado_civiL        = $aportacion->getIdContribuyente()->getNombre();
                $estado_civiL        = "Soltero";
                $correo_electronico  = $aportacion->getIdContribuyente()->getCorreo();
                $rfc                 = $aportacion->getIdContribuyente()->getRfc();
                $curp                = $aportacion->getIdContribuyente()->getCurp();
                $fecha               = $aportacion->getIdContribuyente()->getFechaNacimiento()->format('Y-m-d');
                $fecha_nacimiento    = new \DateTime($fecha);
                $data = $this->opergobserviceadapter->AgregarContribuyente($nombre ,$apellido_paterno ,$apellido_materno ,$genero ,$estado_civiL ,$correo_electronico , $rfc  ,$curp  ,$fecha_nacimiento ,$fecha_nacimiento );
                $cvpersona = $data->IdEntity;

                $contribuyente->setCvePersona($cvpersona);

                $this->entityManager->persist($contribuyente);
                $this->entityManager->flush();
        }
        $añoInicial =  $aportacion->getEjercicioFiscal();
        $añoFinal =  $aportacion->getEjercicioFiscal();
        $ubicacion =  $aportacion->getIdPredio()->getUbicacion();
        $localidad =  $aportacion->getIdPredio()->getLocalidad();
        $id =  $aportacion->getIdAportacion();
        $observacion =  $aportacion->getIdPredio()->getObservaciones();
        $loteConflicto =  $aportacion->getIdPredio()->getLoteConflicto();
        $pagoAportacion = $aportacion->getPago();
        $Addsolicitud = $this->opergobserviceadapter->AddSolicitud($cvpersona,$añoInicial,$añoFinal,$ubicacion,$localidad,$id,$observacion,$loteConflicto);
        $idSolicitud = $Addsolicitud->IdEntity;
        $FuenteIngreso = $this->opergobserviceadapter->SolicitudFuentaIngreso($idSolicitud, $pagoAportacion);

        $aportacion->setIdSolicitud($idSolicitud);
        $aportacion->setEstatus($status);

        $this->entityManager->persist($aportacion);
        $this->entityManager->flush();

        }

        elseif($status==2){
        $aportacion->setEstatus($status);

        $this->entityManager->persist($aportacion);
        $this->entityManager->flush();
        }


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
        //$aportacion->setPago($data['pago_a']);
        $fecha = new \DateTime($data['vig']);//fecha
        $aportacion->setFecha($fecha);
        $aportacion->setMetrosTerreno($data['terreno']);
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
        $aportacion->setEjercicioFiscal($data['ejercicio_fiscal']);
        //$pago_aportacion = $data['tasa_hidden']*$avaluo;
        //$aportacion->setPago($pago_aportacion);//Pago aportacion

        if (is_numeric($data['pago_a'])) {
                $aportacion->setPago($data['pago_a']);
            }else{
                //$aportacion->setPago(substr($data['pago_a'],1));
                $pago_aportacion = $data['tasa_hidden']*$avaluo;
                $aportacion->setPago($pago_aportacion);//Pago aportacion
            }
         //Pago aportacion


        // $currentDate = new \DateTime();
        // $aportacion->setUpdatedAt($currentDate);
        $this->entityManager->persist($aportacion);
        $this->entityManager->flush();
    }

    public function guardarTest($datos)
        {
            if($datos['Idaportacion'] > 0 && $datos['Idcontribuyente'] > 0){

                $aportacionId = $datos['Idaportacion'];
                $contribuyenteId = $datos['Idcontribuyente'];

                $aportacion       = $this->entityManager->getRepository(Aportacion::class)->findOneByIdAportacion($aportacionId);
                $predioId         = $aportacion->getIdPredio()->getIdPredio();
                $predio           = $this->entityManager->getRepository(Predio::class)->findOneByIdPredio($predioId);
                $contribuyente    = $this->entityManager->getRepository(Contribuyente::class)->findOneByIdContribuyente($contribuyenteId);

            }
            elseif($datos['Idaportacion'] > 0 && $datos['Idcontribuyente'] < 1){

            $aportacionId = $datos['Idaportacion'];

            $aportacion       = $this->entityManager->getRepository(Aportacion::class)->findOneByIdAportacion($aportacionId);
            $contribuyenteId = $aportacion->getIdContribuyente()->getIdContribuyente();
            $predioId        = $aportacion->getIdPredio()->getIdPredio();
            $predio          = $this->entityManager->getRepository(Predio::class)->findOneByIdPredio($predioId);
            $contribuyente   = $this->entityManager->getRepository(Contribuyente::class)->findOneByIdContribuyente($contribuyenteId);
            }
            elseif($datos['Idaportacion'] < 1 && $datos['Idcontribuyente'] > 0){

                $contribuyenteId = $datos['Idcontribuyente'];

                $contribuyente   = $this->entityManager->getRepository(Contribuyente::class)->findOneByIdContribuyente($contribuyenteId);
                $predio             = new Predio();
                $aportacion         = new Aportacion();
            }
            else{
            $contribuyente      = new Contribuyente();
            $predio             = new Predio();
            $aportacion         = new Aportacion();
            }

            //Hacer 1 MIllon de registros/////
            // for ($i = 0; $i < 100; ++$i) {
            // $contribuyente      = new Contribuyente();
            // $predio             = new Predio();
            // $aportacion         = new Aportacion();
           //}
           ////////////////////////////

            //////Contribuyente/////
            if($datos['tipoContribuyente']=="F"){
            $contribuyente->setTipoPersona($datos['tipoContribuyente']);
            $contribuyente->setNombre($datos['nombreContribuyente']);
            $contribuyente->setApellidoPaterno($datos['apellidoPaterno']);
            $contribuyente->setApellidoMaterno($datos['apellidoMaterno']);
            $contribuyente->setRfc($datos['rfc']);
            $contribuyente->setRazonSocial($datos['nombreContribuyente']." ".$datos['apellidoPaterno']." ".$datos['apellidoMaterno']);
            $contribuyente->setCurp($datos['curp']);
            $fecha_nacimiento = new \DateTime($datos['año']."-".$datos['mes']."-".$datos['dia']);
            $contribuyente->setFechaNacimiento($fecha_nacimiento);
            $contribuyente->setCorreo($datos['correoElectronico']);
            $contribuyente->setTelefono($datos['telefono']);
            $contribuyente->setGenero($datos['genero']);
            $contribuyente->setEstadoCivil($datos['estadoCivil']);
            $contribuyente->setCvePersona(NULL);
            }else if($datos['tipoContribuyente']=="M"){
            $contribuyente->setTipoPersona($datos['tipoContribuyente']);
            $contribuyente->setNombre($datos['nombreContribuyente']);
            $contribuyente->setApellidoPaterno(NULL);
            $contribuyente->setApellidoMaterno(NULL);
            $contribuyente->setRfc($datos['rfc']);
            $contribuyente->setRazonSocial($datos['razonSocial']);
            $contribuyente->setCurp(NULL);
            $currentDate = new \DateTime();
            $contribuyente->setFechaNacimiento($currentDate);
            $contribuyente->setCorreo($datos['correoElectronico']);
            $contribuyente->setTelefono($datos['telefono']);
            $contribuyente->setEstadoCivil(NULL);
            $contribuyente->setCvePersona(NULL);
            }

            $this->entityManager->persist($contribuyente);
            $this->entityManager->flush();
            // // //  //////Predio/////
            $predio->setIdContribuyente($contribuyente);

            $this->entityManager->persist($predio);
            $this->entityManager->flush();
            // //////Aportacion/////
            $aportacion->setIdContribuyente($contribuyente);
            $aportacion->setIdPredio($predio);

            $aportacion->setEstatus(0);
            $this->entityManager->persist($aportacion);
            $this->entityManager->flush();



            if ($aportacion->getIdAportacion() > 0) {
                return $aportacion;
            }

            return 0;


        }

        public function guardarAportacion($datos)
    {

            if($datos['Idaportacion'] > 0 && $datos['Idcontribuyente'] > 0){

                $aportacionId = $datos['Idaportacion'];
                $contribuyenteId = $datos['Idcontribuyente'];

                $aportacion       = $this->entityManager->getRepository(Aportacion::class)->findOneByIdAportacion($aportacionId);
                $predioId         = $aportacion->getIdPredio()->getIdPredio();
                $predio           = $this->entityManager->getRepository(Predio::class)->findOneByIdPredio($predioId);
                $contribuyente    = $this->entityManager->getRepository(Contribuyente::class)->findOneByIdContribuyente($contribuyenteId);

            }
            elseif($datos['Idaportacion'] > 0 && $datos['Idcontribuyente'] < 1){

            $aportacionId = $datos['Idaportacion'];

            $aportacion       = $this->entityManager->getRepository(Aportacion::class)->findOneByIdAportacion($aportacionId);
            $contribuyenteId = $aportacion->getIdContribuyente()->getIdContribuyente();
            $predioId        = $aportacion->getIdPredio()->getIdPredio();
            $predio          = $this->entityManager->getRepository(Predio::class)->findOneByIdPredio($predioId);
            $contribuyente   = $this->entityManager->getRepository(Contribuyente::class)->findOneByIdContribuyente($contribuyenteId);
            }
            elseif($datos['Idaportacion'] < 1 && $datos['Idcontribuyente'] > 0){

                $contribuyenteId = $datos['Idcontribuyente'];

                $contribuyente   = $this->entityManager->getRepository(Contribuyente::class)->findOneByIdContribuyente($contribuyenteId);
                $predio             = new Predio();
                $aportacion         = new Aportacion();
            }
            else{
            $contribuyente      = new Contribuyente();
            $predio             = new Predio();
            $aportacion         = new Aportacion();
            }

        //////Guardar Contribuyente///////
            $contribuyente->setNombre($datos['Contribuyente']);
            $contribuyente->setFactura($datos['factura']);
            $contribuyente->setGiroComercial($datos['giroComercial']);
            $contribuyente->setNombreComercial($datos['nombreComercial']);
            $contribuyente->setTenencia($datos['tenencia']);
            $contribuyente->setRfc($datos['rfContribuyente']);
            $contribuyente->setUsoDestino($datos['usoDestino']);

            $currentDate = new \DateTime();
            $contribuyente->setCreatedAt($currentDate);
            $contribuyente->setUpdatedAt($currentDate);

            $this->entityManager->persist($contribuyente);
            $this->entityManager->flush();
        ///////Guarda Predio////////

            $predio->setIdContribuyente($contribuyente);
            $predio->setParcela($datos['parcela']);
            $predio->setManzana($datos['manzana']);
            $predio->setLote($datos['lote']);
            $predio->setLocal($datos['local']);
            $predio->setCategoria($datos['categoria']);
            $predio->setCondicion($datos['condicion']);
            $predio->setTitular($datos['titular']);
            $predio->setUbicacion($datos['ubicacion']);
            $predio->setLocalidad($datos['localidad']);
            $predio->setAntecedentes($datos['antecedentes']);
            $predio->setClaveCatastral($datos['claveCatastral']);
            $predio->setRegimenPropiedad($datos['regimenPropiedad']);
            $fecha_adquicision = new \DateTime($datos['fechaAdquicision']);
            //$fecha_adquicision = new \DateTime($datos['año']."-".$datos['mes']."-".$datos['dia']);
            $predio->setFechaAdquicision($fecha_adquicision);
            $predio->setTitularAnterior($datos['titularAnterior']);
            $predio->setDocumentoPropiedad($datos['documentoPropiedad']);
            $predio->setFolio($datos['folio']);
            $fecha_documento = new \DateTime($datos['fechaDocumento']);
            $predio->setFechaDocumento($fecha_documento);
            $predio->setLoteConflicto($datos['loteConflicto']);
            $predio->setObservaciones($datos['observaciones']);
            $this->entityManager->persist($predio);
            $this->entityManager->flush();

            ////////Guarda Aportacion///////
            $aportacion->setIdContribuyente($contribuyente);
            $aportacion->setIdPredio($predio);
            $aportacion->setEstatus(3);

            $fecha = new \DateTime($datos['fecha']);//fecha
            $aportacion->setFecha($fecha);
            $aportacion->setMetrosTerreno($datos['metrosTerreno']);
            $aportacion->setValorZona($datos['valorMZona']);
            $valorTerreno = $datos['metrosTerreno'] * $datos['valorMZona'];
            $aportacion->setValorTerreno($valorTerreno);
            $aportacion->setMetrosConstruccion($datos['metrosConstruccion']);
            $aportacion->setValorMtsConstruccion($datos['valorMConstruccion']);
            $ValorConstruccion = $datos['metrosConstruccion'] * $datos['valorMConstruccion'];
            $aportacion->setValorConstruccion($ValorConstruccion);
            $aportacion->setEjercicioFiscal($datos['ejercicioFiscal']);
            $aportacion->setEjercicioFiscalFinal($datos['ejercicioFiscalFinal']);
            $aportacion->setTasa($datos['tasa']);
            $avaluo = $valorTerreno + $ValorConstruccion;
            $aportacion->setAvaluo($avaluo);
            $pagoAportacion = $avaluo * $datos['tasa'];
            $año_default = 1;
            $año_inicial = $datos['ejercicioFiscal'];
            $año_final = $datos['ejercicioFiscalFinal'];
            $resultado = $año_final-$año_inicial+$año_default;
            $aportacion_final = $resultado * $pagoAportacion;
            $aportacion->setPago($aportacion_final);

            $this->entityManager->persist($aportacion);
            $this->entityManager->flush();

            if ($aportacion->getIdAportacion() > 0) {
                return $aportacion;
            }


    }

    public function actualizarAportacion($datos)
    {
        $aportacionId = $datos['Idaportacion'];
        $apotacion = $this->entityManager->getRepository(Aportacion::class)->findOneByIdAportacion($aportacionId);
        $contribuyenteId = $apotacion->getIdContribuyente()->getIdContribuyente();
        $predioId = $apotacion->getIdPredio()->getIdPredio();
        $predio = $this->entityManager->getRepository(Predio::class)->findOneByIdPredio($predioId);
        $contribuyente = $this->entityManager->getRepository(Contribuyente::class)->findOneByIdContribuyente($contribuyenteId);


        $predio->setParcela($datos['parcela']);
        $predio->setManzana($datos['manzana']);
        $predio->setLote($datos['lote']);
        $predio->setLocal($datos['local']);
        $predio->setCategoria($datos['categoria']);
        $predio->setCondicion($datos['condicion']);
        $predio->setTitular($datos['titular']);
        $predio->setUbicacion($datos['ubicacion']);
        $predio->setLocalidad($datos['localidad']);
        $predio->setAntecedentes($datos['antecedentes']);
        $predio->setClaveCatastral($datos['claveCatastral']);
        // $predio->setRegimenPropiedad($datos['regimenPropiedad']);
        $fecha_adquicision = new \DateTime($datos['fechaAdquicision']);
        $predio->setFechaAdquicision($fecha_adquicision);

        $this->entityManager->persist($predio);
        $this->entityManager->flush();

    }
///////////Agregar Colindancias Datatble/////////
    public function guardarColindancias($datos)
        {
            if($datos['Idaportacion'] > 0 ){
            $predioColindancias = new PredioColindancia();
            $aportacionId       = $datos['Idaportacion'];
            $aportacion         = $this->entityManager->getRepository(Aportacion::class)->findOneByIdAportacion($aportacionId);
            $contribuyenteId    = $aportacion->getIdContribuyente()->getIdContribuyente();
            $predioId           = $aportacion->getIdPredio()->getIdPredio();
            $predio             = $this->entityManager->getRepository(Predio::class)->findOneByIdPredio($predioId);
            $contribuyente      = $this->entityManager->getRepository(Contribuyente::class)->findOneByIdContribuyente($contribuyenteId);
            }
            else
            {
            $contribuyente      = new Contribuyente();
            $predio             = new Predio();
            $predioColindancias = new PredioColindancia();
            $aportacion         = new Aportacion();
            }

            //////Contribuyente/////
            $this->entityManager->persist($contribuyente);
            $this->entityManager->flush();
            // //  //////Predio/////
            $predio->setIdContribuyente($contribuyente);

            $this->entityManager->persist($predio);
            $this->entityManager->flush();
            // // //////PredioColindancia///////
            $predioColindancias->setIdPredio($predio);
            $predioColindancias->setPuntoCardinal($datos['puntoCardinal']);
            $predioColindancias->setMedidaMetrosLineales($datos['medidasMetros']);
            $predioColindancias->setColindancia($datos['colindaCon']);
            $predioColindancias->setObservaciones($datos['observacionesColindacias']);


            $this->entityManager->persist($predioColindancias);
            $this->entityManager->flush();
            //////Aportacion/////
            $aportacion->setIdContribuyente($contribuyente);
            $aportacion->setIdPredio($predio);
            $aportacion->setEstatus(0);


            $this->entityManager->persist($aportacion);
            $this->entityManager->flush();

            if ($aportacion->getIdAportacion() > 0) {


                return $aportacion;
            }

            return 0;
        }
///////////Eliminar Colindancias Datatble/////////
    public function eliminarColindancias($predioColindancia)
    {
        $this->entityManager->remove($predioColindancia);
        $this->entityManager->flush();
    }
///////////Actualizar Colindancias Datatble/////////
public function actualizarColindancias($datos)
    {
        $predioColindanciasId = $datos['id'];
        $predioColindancias = $this->entityManager->getRepository(PredioColindancia::class)->findOneByIdPredioColindancia($predioColindanciasId);


        $predioColindancias->setPuntoCardinal($datos['puntoCardinal']);
        $predioColindancias->setMedidaMetrosLineales($datos['medidasMetros']);
        $predioColindancias->setColindancia($datos['colindaCon']);
        $predioColindancias->setObservaciones($datos['observacionesColindacias']);

        $this->entityManager->persist($predioColindancias);
        $this->entityManager->flush();
    }

    public function guardarLocalidad()
    {
        $localidadesWeb = $this->opergobserviceadapter->obtenerLocalidadByCveEntidadFederativa("23", "09");

        foreach($localidadesWeb->Localidad as $item)
        {
            $localidades = new Localidad();

            $localidades->setCveDistrito($item->CveDistrito);
            $localidades->setCveEntidadFederativa($item->CveEntidadFederativa);
            $localidades->setCveLocalidad($item->CveLocalidad);
            $localidades->setCveMunicipio($item->CveMunicipio);
            $localidades->setCveRegion($item->CveRegion);
            $localidades->setNombreLocalidad(utf8_decode($item->NombreLocalidad));
            $localidades->setNombreOficialLocalidad(utf8_decode($item->NombreOficialLocalidad));

            $this->entityManager->persist($localidades);
            $this->entityManager->flush();
        }
    }

    public function guardargiroComercial()
    {
        $girocomercialesWeb = $this->opergobserviceadapter->obtenerGiroComercialByCveFte('MTULUM', "2020");

        foreach($girocomercialesWeb->GiroComercial as $item)
        {
            $girocomerciales = new GiroComercial();

            $girocomerciales->setCveFtmMt($item->CveFteMT);
            $girocomerciales->setGiroComercialDescripcion($item->GirosComercialesDescripcion);
            $girocomerciales->setTarifasLicenciasBasuraCveFteIngBasura($item->TarifasLicenciasBasuraCveFteIngBasura);
            $girocomerciales->setTarifasLicenciasBasuraCveFteIngLicencia($item->TarifasLicenciasBasuraCveFteIngLicencia);
            $girocomerciales->setTarifasLicenciasBasuraImporteBasura($item->TarifasLicenciasBasuraImporteBasura);
            $girocomerciales->setTarifasLicenciasBasuraImporteLicencia($item->TarifasLicenciasBasuraImporteLicencia);

            $this->entityManager->persist($girocomerciales);
            $this->entityManager->flush();
        }
    }
}
