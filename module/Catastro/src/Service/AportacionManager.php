<?php

namespace Catastro\Service;

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
        $aportacion = new Aportacion();

        $aportacion->setNombre($data['nombre']);
        $aportacion->setApellidoPaterno($data['apellido_paterno']);
        $aportacion->setApellidoMaterno($data['apellido_materno']);
        $aportacion->setRfc($data['rfc']);
        $aportacion->setCurp($data['curp']);
        $aportacion->setGenero($data['genero']);

        $this->entityManager->persist($aportacion);
        $this->entityManager->flush();
    }

    public function actualizar($aportacion, $data)
    {
        $aportacion->setNombre($data['nombre']);
        $aportacion->setApellidoPaterno($data['apellido_paterno']);
        $aportacion->setApellidoMaterno($data['apellido_materno']);
        $aportacion->setRfc($data['rfc']);
        $aportacion->setCurp($data['curp']);
        $aportacion->setGenero($data['genero']);

        $this->entityManager->flush();
    }

    public function eliminar($aportacion)
    {
        $this->entityManager->remove($aportacion);

        $this->entityManager->flush();
    }
}
