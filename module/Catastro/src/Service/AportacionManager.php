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



    public function guardarPersona($data)
    {
            $contribuyente = new Contribuyente();
            //////Contribuyente/////
            $contribuyente->setApellidoPaterno(ucfirst($data['apellido_paterno']));
            $contribuyente->setApellidoMaterno(ucfirst($data['apellido_materno']));
            $contribuyente->setTipoPersona($data['tipo_persona']);
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
                $genero              = $aportacion->getIdContribuyente()->getGenero();
                $estado_civiL        = $aportacion->getIdContribuyente()->getEstadoCivil();
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

    public function actualizarValidation($aportacion, $data)
    {

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
        $aportacion->setEjercicioFiscalFinal($data['ejercicio_fiscal_final']);
        $pago_aportacion = $data['tasa_hidden']*$avaluo;
        $año_default = 1;
        $año_inicial = $data['ejercicio_fiscal'];
        $año_final = $data['ejercicio_fiscal_final'];
        $resultado = $año_final-$año_inicial+$año_default;
        $aportacion_final = $resultado * $pago_aportacion;

        if (is_numeric($data['pago_a'])) {
                $aportacion->setPago($data['pago_a']);
            }
            else{
                $aportacion->setPago($aportacion_final);
            }

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
            $predio->setTipoPredio(3);

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

    /////Agregar Colindancias Datatble/////////
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
   //////Eliminar Colindancias Datatble/////////
    public function eliminarColindancias($predioColindancia)
    {
        $this->entityManager->remove($predioColindancia);
        $this->entityManager->flush();
    }
    ////Actualizar Colindancias Datatble/////////
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
