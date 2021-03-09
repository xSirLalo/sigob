<?php

namespace Catastro\Service;

use Catastro\Entity\Predio;
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

    public function guardar($data)
    {
        $predio = new Predio();

        $predio->setClaveCatastral($data['cve_catastral']);
        $predio->setUbicacion($data['ubicacion']);
        $predio->setTitular($data['titular']);
        $predio->setTitularAnterior($data['titular_anterior']);

        $currentDate = new \DateTime();
        $predio->setCreatedAt($currentDate);
        $predio->setUpdatedAt($currentDate);

        $this->entityManager->persist($predio);
        $this->entityManager->flush();
    }

    public function actualizar($predio, $data)
    {
        $predio->setNombre($data['nombre']);

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
