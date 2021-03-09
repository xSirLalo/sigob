<?php

namespace Catastro\Service;

use Catastro\Entity\Predio;
use Catastro\Entity\PredioColindancia;
use Catastro\Entity\Aportacion;

class AportacionManager
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
        $Aportacion = new Aportacion();

        $aportacion->setPago($data['pago']);

        $currentDate = new \DateTime();
        $aportacion->setCreatedAt($currentDate);
        $aportacion->setUpdatedAt($currentDate);

        $this->entityManager->persist($aportacion);
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
