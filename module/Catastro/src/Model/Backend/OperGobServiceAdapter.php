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
            "Criterio" => $rfc
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

}
