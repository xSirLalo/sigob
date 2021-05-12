<?php

namespace Catastro\Service;

use Catastro\Entity\Predio;
use Catastro\Entity\Contribuyente;
use Catastro\Entity\PredioColindancia;

class PredioManager
{
    private $entityManager;

    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function guardarPredio($contribuyente, $data)
    {
        $predio = new Predio();

        $predio->setIdContribuyente($contribuyente);
        $predio->setColonia($data['colonia']);
        $predio->setLocalidad($data['localidad']);
        $predio->setMunicipio($data['municipio']);
        $predio->setCalle($data['calle']);
        $predio->setClaveCatastral($data['cve_catastral']);
        $predio->setCvePredio($data['cve_predio']);
        $predio->setNumeroExterior($data['numero_exterior']);
        $predio->setNumeroInterior($data['numero_interior']);
        $predio->setTipo($data['tipo']);
        $predio->setUltimoEjercicioPagado($data['ultimo_ejercicio_pagado']);
        $predio->setUltimoPeriodoPagado($data['ultimo_periodo_pagado']);
        $predio->setTitular($data['titular']);
        $predio->setTitularAnterior($data['titular_anterior']);
        $predio->setCreatedAt(new \DateTime());
        $predio->setUpdatedAt(new \DateTime());

        $this->entityManager->persist($predio);
        $this->entityManager->flush();

        if ($predio->getIdPredio() > 0) {
            return $predio;
        }
        return null;
    }

    public function actualizarPredio($predio, $data)
    {
        $predio->setColonia($data['colonia']);
        $predio->setLocalidad($data['localidad']);
        $predio->setMunicipio($data['municipio']);
        $predio->setCalle($data['calle']);
        // $predio->setClaveCatastral($data['cve_catastral']);
        // $predio->setCvePredio($data['cve_predio']);
        $predio->setNumeroExterior($data['numero_exterior']);
        $predio->setNumeroInterior($data['numero_interior']);
        // $predio->setEstatus($data['estatus']);
        // $predio->setTipo($data['tipo']);
        $predio->setUltimoEjercicioPagado($data['ultimo_ejercicio_pagado']);
        $predio->setUltimoPeriodoPagado($data['ultimo_periodo_pagado']);
        $predio->setTitular($data['titular']);
        $predio->setTitularAnterior($data['titular_anterior']);
        $predio->setUpdatedAt(new \DateTime());

        $this->entityManager->flush();
    }

    public function guardarColindancia($predio, $data)
    {
        $predioColindacia = new PredioColindancia();

        $predioColindacia->setIdPredio($predio);
        $predioColindacia->setDescripcion($data['descripcion']);
        $predioColindacia->setMedidaMetros($data['medida_metros']);
        $predioColindacia->setOrientacionGeografica($data['orientacion_geografica']);

        $this->entityManager->persist($predioColindacia);
        $this->entityManager->flush();
    }

}
