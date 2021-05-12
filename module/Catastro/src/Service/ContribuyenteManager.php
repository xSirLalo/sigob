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

    public function guardarPersona($data)
    {
        $contribuyente = new Contribuyente();

        $contribuyente->setApellidoPaterno(ucfirst($data['apellido_paterno']));
        $contribuyente->setApellidoMaterno(ucfirst($data['apellido_materno']));
        $contribuyente->setCurp($data['curp']);
        $contribuyente->setCvePersona($data['cve_persona']);
        $contribuyente->setGenero($data['genero']);
        $contribuyente->setNombre($data['nombre']);
        $contribuyente->setTelefono($data['telefono']);
        $contribuyente->setCorreo($data['correo']);
        $contribuyente->setRfc($data['rfc']);
        $contribuyente->setRazonSocial($data['razon_social']);
        $contribuyente->setTipoPersona($data['tipo_persona']);
        $contribuyente->setCreatedAt(new \DateTime());
        $contribuyente->setUpdatedAt(new \DateTime());

        $this->entityManager->persist($contribuyente);
        $this->entityManager->flush();

        if ($contribuyente->getIdContribuyente() > 0) {
            return $contribuyente;
        }
        return false;
    }

    public function guardarContribuyente($data)
    {
        $contribuyente = new Contribuyente();

        if ($data['tipo_persona'] == 'F') { // Persona Fisica
            $contribuyente->setApellidoPaterno(ucfirst($data['apellido_paterno']));
            $contribuyente->setApellidoMaterno(ucfirst($data['apellido_materno']));
            $contribuyente->setFechaNacimiento(new \DateTime($data['fecha_nacimiento']));
            $contribuyente->setEstadoCivil($data['estado_civil']);
            $contribuyente->setCurp($data['curp']);
            $contribuyente->setGenero($data['genero']);
            $contribuyente->setRazonSocial(ucfirst($data['nombre']) ." ". ucfirst($data['apellido_paterno']) ." ". ucfirst($data['apellido_materno']));
        } elseif ($data['tipo_persona'] == 'M') { // Persona Moral
            $contribuyente->setRazonSocial($data['razon_social']);
        }

        $contribuyente->setTipoPersona($data['tipo_persona']);
        $contribuyente->setNombre(ucfirst($data['nombre']));
        $contribuyente->setTelefono($data['telefono']);
        $contribuyente->setCorreo($data['correo']);
        $contribuyente->setRfc($data['rfc']);
        $contribuyente->setCreatedAt(new \DateTime());
        $contribuyente->setUpdatedAt(new \DateTime());

        $this->entityManager->persist($contribuyente);
        $this->entityManager->flush();

        if ($contribuyente->getIdContribuyente() > 0) {
            return $contribuyente;
        }
        return false;
    }

    public function actualizarContribuyente($contribuyente, $data)
    {
        if ($data['tipo_persona'] == 'F') { // Persona Fisica
            $contribuyente->setApellidoPaterno(ucfirst($data['apellido_paterno']));
            $contribuyente->setApellidoMaterno(ucfirst($data['apellido_materno']));
            $contribuyente->setFechaNacimiento(new \DateTime($data['fecha_nacimiento']));
            $contribuyente->setEstadoCivil($data['estado_civil']);
            $contribuyente->setCurp($data['curp']);
            $contribuyente->setGenero($data['genero']);
            $contribuyente->setRazonSocial(ucfirst($data['nombre']) ." ". ucfirst($data['apellido_paterno']) ." ". ucfirst($data['apellido_materno']));
        } elseif ($data['tipo_persona'] == 'M') { // Persona Moral
            $contribuyente->setRazonSocial($data['razon_social']);
        }

        $contribuyente->setTipoPersona($data['tipo_persona']);
        $contribuyente->setNombre($data['nombre']);
        $contribuyente->setTelefono($data['telefono']);
        $contribuyente->setCorreo($data['correo']);
        $contribuyente->setRfc($data['rfc']);
        $contribuyente->setUpdatedAt(new \DateTime());

        $this->entityManager->flush();
    }

    public function eliminar($contribuyente)
    {
        $this->entityManager->remove($contribuyente);

        $this->entityManager->flush();
    }

}
