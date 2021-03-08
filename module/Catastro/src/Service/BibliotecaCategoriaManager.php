<?php

namespace Catastro\Service;

use Catastro\Entity\ArchivoCategoria as Categoria;

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
        $categoria = new Categoria();

        $categoria->setNombre($data['nombre']);

        $currentDate = new \DateTime();
        $categoria->setCreatedAt($currentDate);
        $categoria->setUpdatedAt($currentDate);

        $this->entityManager->persist($categoria);

        $this->entityManager->flush();
    }

    public function actualizar($categoria, $data)
    {
        $categoria->setNombre($data['nombre']);

        $currentDate = new \DateTime();
        $contribuyente->setUpdatedAt($currentDate);

        $this->entityManager->flush();
    }

    public function eliminar($categoria)
    {
        $this->entityManager->remove($categoria);

        $this->entityManager->flush();
    }
}
