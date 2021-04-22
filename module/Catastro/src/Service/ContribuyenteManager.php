<?php

namespace Catastro\Service;

use Catastro\Entity\Contribuyente;

class ContribuyenteManager
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

    public function guardarContribuyente($data)
    {
        $contribuyente = new Contribuyente();
        $currentDate = new \DateTime();

        if ($data['tipo_persona'] == 'F') { // Persona Fisica
            $contribuyente->setApellidoPaterno(ucfirst($data['apellido_paterno']));
            $contribuyente->setApellidoMaterno(ucfirst($data['apellido_materno']));
            $contribuyente->setCurp($data['curp']);
            $contribuyente->setGenero($data['genero']);
        } elseif ($data['tipo_persona'] == 'M') { // Persona Moral
            $contribuyente->setRazonSocial($data['razon_social']);
        }

        $contribuyente->setNombre(ucfirst($data['nombre']));
        $contribuyente->setTelefono($data['telefono']);
        $contribuyente->setCorreo($data['correo']);
        $contribuyente->setRfc($data['rfc']);

        $contribuyente->setCreatedAt($currentDate);
        $contribuyente->setUpdatedAt($currentDate);

        $this->entityManager->persist($contribuyente);
        $this->entityManager->flush();
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
        $contribuyente->setRazonSocial($data['razon_social']);

        $currentDate = new \DateTime();
        $contribuyente->setCreatedAt($currentDate);
        $contribuyente->setUpdatedAt($currentDate);

        $this->entityManager->persist($contribuyente);
        $this->entityManager->flush();

        if ($contribuyente->getIdContribuyente() > 0) {
            return $contribuyente;
        }
        return false;
    }

    public function actualizarContribuyente($contribuyente, $data)
    {
        $currentDate = new \DateTime();

        if ($data['tipo_persona'] == 'F') { // Persona Fisica
            $contribuyente->setApellidoPaterno($data['apellido_paterno']);
            $contribuyente->setApellidoMaterno($data['apellido_materno']);
            $contribuyente->setCurp($data['curp']);
            $contribuyente->setGenero($data['genero']);
        } elseif ($data['tipo_persona'] == 'M') { // Persona Moral
            $contribuyente->setRazonSocial($data['razon_social']);
        }

        $contribuyente->setNombre($data['nombre']);
        $contribuyente->setTelefono($data['telefono']);
        $contribuyente->setCorreo($data['correo']);
        $contribuyente->setRfc($data['rfc']);

        $contribuyente->setUpdatedAt($currentDate);

        $this->entityManager->flush();
    }

    public function eliminar($contribuyente)
    {
        $this->entityManager->remove($contribuyente);

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
