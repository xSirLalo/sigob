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

    public function agregar($data)
    {
        $Predio = new Predio();

        $Predio->setNombre($data['nombre']);

        $currentDate = new \DateTime();
        $Predio->setCreatedAt($currentDate);
        $Predio->setUpdatedAt($currentDate);

        $this->entityManager->persist($Predio);
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
