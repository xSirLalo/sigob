<?php

namespace Catastro\Service;

use Catastro\Entity\ArchivoCategoria as Categoria;

class BibliotecaCategoriaManager
{
    private $entityManager;

    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function agregar($data)
    {
        // Crea un entity Categoria.
        $categoria = new Categoria();

        $categoria->setNombre($data['nombre']);
        $categoria->setCreatedAt(new \DateTime());
        $categoria->setUpdatedAt(new \DateTime());
        // Agrega el entity en el entity manager.
        $this->entityManager->persist($categoria);
        // Aplicar cambios a la base de datos.
        $this->entityManager->flush();
    }

    public function actualizar($categoria, $data)
    {
        $categoria->setNombre($data['nombre']);
        $categoria->setUpdatedAt(new \DateTime());
        // Aplicar cambios a la base de datos.
        $this->entityManager->flush();
    }

    public function eliminar($categoria)
    {
        $this->entityManager->remove($categoria);
        // Aplicar cambios a la base de datos.
        $this->entityManager->flush();
    }
}
