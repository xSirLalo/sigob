<?php

namespace Catastro\Service;

use Catastro\Entity\Archivo  as Biblioteca;

class BibliotecaManager
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
        $biblioteca = new Biblioteca();


        $this->entityManager->persist($biblioteca);
        $this->entityManager->flush();
    }

    public function actualizar($biblioteca, $data)
    {
        $this->entityManager->flush();
    }

    public function eliminar($biblioteca)
    {
        $this->entityManager->remove($biblioteca);

        $this->entityManager->flush();
    }
}
