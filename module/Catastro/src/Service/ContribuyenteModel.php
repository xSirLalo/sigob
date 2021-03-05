<?php

namespace Catastro\Service;

use Catastro\Entities\Contribuyente;

class ContribuyenteModel
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
        $contribuyente->setApellidoPaterno($data['apellido_materno']);
        $contribuyente->setRfc($data['rfc']);
        $contribuyente->setCurp($data['curp']);
        $contribuyente->setGenero($data['genero']);
        $this->entityManager->persist($contribuyente);
        $this->entityManager->flush();
    }

    public function delete($contribuyente)
    {
        $this->entityManager->remove($contribuyente);
        $this->entityManager->flush();
    }

    public function update($contribuyente, $data)
    {
        $contribuyente->setNombre($data['nombre']);
        $this->entityManager->flush();
    }

    public function mostrarContribuyentes()
    {
        $contribuyentes  = $this->entityManager->createQuery("SELECT c FROM Catastro\Model\Entity\Contribuyentes c ORDER BY c.id ASC")->getResult();
        $row = [];

        foreach ($contribuyentes as $tuple) {
            $row[$tuple->getId()] = $tuple->getNombre(). ' ' . $tuple->getApellidoPaterno(). ' ' . $tuple->getApellidoMaterno();
        }

        return $row;
    }
}
