<?php

namespace Catastro\Model\Backend;

use Laminas\Soap\AutoDiscover;
use Laminas\Soap\Client;
use Laminas\Soap\Server;
use Laminas\Soap\Wsdl;

ini_set("soap.wsdl_cache_enabled", "0");

class OperGobServiceAdapter{

    const URI_SERVICE_OPER = "http://sistematulum.net:8081/Service.svc?wsdl";

    public function obtenerPersonaPorRfc($rfc) {
        $respuesta = array();

        $parametros = [
            //"Criterio" => $rfc
            "Rfc" => $rfc
        ];

        $client = new Client();
        $client->setWsdl(self::URI_SERVICE_OPER);
        $client->setOptions([
            "soap_version" => \SOAP_1_1,
            "encoding" => 'UTF-8',
        ]);

        $respuesta = $client->GetPersonaByRfc($parametros);
        return $respuesta->GetPersonaByRfcResult;
    }

    public function obtenerPersonaPorCve($id) {
        $respuesta = array();

        $parametros = [
            "PersonaId" => $id
        ];

        $client = new Client();
        $client->setWsdl(self::URI_SERVICE_OPER);
        $client->setOptions([
            "soap_version" => \SOAP_1_1,
            "encoding" => 'UTF-8',
        ]);

        $respuesta = $client->GetPersonaById($parametros);
        return $respuesta->GetPersonaByIdResult;
    }

    public function obtenerPredio($clave_catastral) {
        $respuesta = array();

        $parametros = [
            "ClaveCatastral" => $clave_catastral
        ];

        $client = new Client();
        $client->setWsdl(self::URI_SERVICE_OPER);
        $client->setOptions([
            "soap_version" => \SOAP_1_1,
            "encoding" => 'UTF-8',
        ]);

        $respuesta = $client->GetPredioByClaveCatastral($parametros);
        return $respuesta->GetPredioByClaveCatastralResult;
    }

    public function obtenerColindancia($predioId) {
        $respuesta = array();

        $parametros = [
            "predioId" => $predioId
        ];

        $client = new Client();
        $client->setWsdl(self::URI_SERVICE_OPER);
        $client->setOptions([
            "soap_version" => \SOAP_1_1,
            "encoding" => 'UTF-8',
        ]);

        $respuesta = $client->GetColindanciaByPredioId($parametros);
        return $respuesta->GetColindanciaByPredioIdResult;
    }

    public function obtenerNombrePersona($nombre) {
        $respuesta = array();

        $parametros = [
            "nombre" => $nombre
        ];

        $client = new Client();
        $client->setWsdl(self::URI_SERVICE_OPER);
        $client->setOptions([
            "soap_version" => \SOAP_1_1,
            "encoding" => 'UTF-8',
        ]);

        $respuesta = $client->GetPersonaLikeName($parametros);
        return $respuesta->GetPersonaLikeNameResult;
    }

    public function AddSolicitud($cvpersona) {

        $hoy = new \DateTime("now");
        $fecha_hoy = new \DateTime("now");
        $fecha_vence = $fecha_hoy->add(\DateInterval::createFromDateString('20 day'));
        $respuesta = array();

        $parametros = [
            "CveFteMT"                  => 'MTULUM',
            "GrupoTramiteId"            => "3", //***
            "TramiteId"                 => "4", //***
            "SolicitudId"               => "0",
            "SolicitudEstado"           => "PP",
            "SolicitudDescripcion"      => "",
            "SolicitudFecha"            => $hoy->format("Y-m-d")."T".$hoy->format("h:i:s"),
            "SolicitudCantidad"         => "0.00",
            "SolicitudRedondear"        => "",
            "CvePersona"                => $cvpersona, //***
            "SolicitudVencimientoFecha" => $fecha_vence->format("Y-m-d")."T".$fecha_vence->format("h:i:s"),
            "SolicitudUsuario"          => "SOPORTE2",
            "SolicitudObservaciones"    => "",
            "SolicitudPadronId"         => "0",
            "SolicitudTipoIngreso"      => "",
        ];

        $client = new Client();
        $client->setWsdl(self::URI_SERVICE_OPER);
        $client->setOptions([
            "soap_version"  => SOAP_1_1,
            'encoding'      => 'UTF-8',
        ]);

        $respuesta = $client->AddSolicitud(array("solicitud"=>$parametros));
        return $respuesta->AddSolicitudResult;
    }

    public function SolicitudFuentaIngreso($idSolicitud, $importe) {

        $respuesta = array();
        $parametros = [
                    'CveFteMT'                        => 'MTULUM',
                    'GrupoTramiteId'                  => "3", //**
                    'TramiteId'                       => "4", //**
                    'SolicitudId'                     => $idSolicitud, //**
                    'SolicitudDetalleId'              => "1",
                    'SolicitudDetalleProtege'         => "S",
                    'SolicitudDetallePermiteEliminar' => "",
                    'SolicitudDetalleCantidad'        => 1.00,
                    'SolicitudDetallePrincipal'       => 0,
                    'SolicitudDetalleFteIngId'        => "4306020103", //**
                    'SolicitudDetalleImporteFijo'     => $importe, //**
                    'SolicitudDetalleEjericicio'      => "0",
                    'SolicitudDetallePeriodo'         => "0",
                    'SolicitudDetalleImporteUnitario' => 0,
                    //'SolicitudDetalleFteIngPermiteModificar'=> 0,
                    'SolicitudDetalleDescuento'       => "",
                    //'SolicitudDetalleFteIngDescuento' => "",
                    'SolicitudDetallePrincipalClave'  => 0,
                    //'SolicitudDetalleFecha'           => "",
                    //'SolicitudDetalleCveTerapeuta'    => "",
                ];

        $client = new Client();
        $client->setWsdl(self::URI_SERVICE_OPER);
        $client->setOptions([
            "soap_version"  => SOAP_1_1,
            'encoding'      => 'UTF-8',
        ]);
        $respuesta = $client->AddSolicitudFuenteIngreso(array("fuente_ingreso"=>$parametros));
        return $respuesta->AddSolicitudFuenteIngresoResult;
    }

    public function obtenerLocalidadByCveEntidadFederativa($CveEntidadFederativa, $CveMunicipio) {
        $respuesta = array();

        $parametros = [
            "CveEntidadFederativa" => $CveEntidadFederativa,
            "CveMunicipio" => $CveMunicipio.""
        ];

        $client = new Client();
        $client->setWsdl(self::URI_SERVICE_OPER);
        $client->setOptions([
            "soap_version" => \SOAP_1_1,
            "encoding" => 'UTF-8',
        ]);

        $respuesta = $client->GetAllLocalidadByCveEntidadFederativa($parametros);
        return $respuesta->GetAllLocalidadByCveEntidadFederativaResult;
    }

    public function obtenerGiroComercialByCveFte($CveFte, $ejercicio) {
        $respuesta = array();

        $parametros = [
            "CveFte" => $CveFte,
            "ejercicio" => $ejercicio
        ];

        $client = new Client();
        $client->setWsdl(self::URI_SERVICE_OPER);
        $client->setOptions([
            "soap_version" => \SOAP_1_1,
            "encoding" => 'UTF-8',
        ]);

        $respuesta = $client->GetAllGiroComercialByCveFte($parametros);
        return $respuesta->GetAllGiroComercialByCveFteResult;
    }

}
