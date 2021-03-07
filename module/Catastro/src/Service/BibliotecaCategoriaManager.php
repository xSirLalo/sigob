<?php

namespace Catastro\Service;

use Catastro\Entity\Contribuyente;

class BibliotecaCategoriaManager
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
        $contribuyente = new Contribuyente();

        $contribuyente->setNombre($data['nombre']);
        $contribuyente->setApellidoPaterno($data['apellido_paterno']);
        $contribuyente->setApellidoMaterno($data['apellido_materno']);
        $contribuyente->setRfc($data['rfc']);
        $contribuyente->setCurp($data['curp']);
        $contribuyente->setGenero($data['genero']);

        $this->entityManager->persist($contribuyente);
        $this->entityManager->flush();
    }

    public function actualizar($contribuyente, $data)
    {
        $contribuyente->setNombre($data['nombre']);
        $contribuyente->setApellidoPaterno($data['apellido_paterno']);
        $contribuyente->setApellidoMaterno($data['apellido_materno']);
        $contribuyente->setRfc($data['rfc']);
        $contribuyente->setCurp($data['curp']);
        $contribuyente->setGenero($data['genero']);

        $this->entityManager->flush();
    }

    public function eliminar($contribuyente)
    {
        $this->entityManager->remove($contribuyente);

        $this->entityManager->flush();
    }
}
