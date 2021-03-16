<?php

namespace Catastro\Service;

use Catastro\Entity\Predio;
use Catastro\Entity\Contribuyente;
use Catastro\Entity\PredioColindancia;

class PredioManager
{
    /**
     * Entity manager.
     * @var Doctrine\ORM\EntityManager;
     */
    private $entityManager;

    /**
     * Constructor.
     */
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
        $predio->setEstatus($data['estatus']);
        $predio->setTipo($data['tipo']);
        $predio->setUltimoEjercicioPagado($data['ultimo_ejercicio_pagado']);
        $predio->setUltimoPeriodoPagado($data['ultimo_periodo_pagado']);
        $predio->setTitular($data['titular']);
        $predio->setTitularAnterior($data['titular_anterior']);

        $currentDate = new \DateTime();
        $predio->setCreatedAt($currentDate);
        $predio->setUpdatedAt($currentDate);

        $this->entityManager->persist($predio);
        $this->entityManager->flush();
         if ($predio->getIdPredio() > 0) {
            return $predio;
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

    public function actualizar($predio, $data)
    {
        $predio->setTitular($data['titular']);

        $currentDate = new \DateTime();
        $predio->setUpdatedAt($currentDate);

        $this->entityManager->flush();
    }

    public function eliminar($predio)
    {
        $this->entityManager->remove($predio);

        $this->entityManager->flush();
    }
}
