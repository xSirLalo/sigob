<?php

namespace Catastro\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Contribuyente
 *
 * @ORM\Table(name="contribuyente")
 * @ORM\Entity
 */
class Contribuyente
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_contribuyente", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idContribuyente;

    /**
     * @var int|null
     *
     * @ORM\Column(name="cve_persona", type="bigint", nullable=true)
     */
    private $cvePersona;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nombre", type="string", length=255, nullable=true)
     */
    private $nombre;

    /**
     * @var string|null
     *
     * @ORM\Column(name="apellido_paterno", type="string", length=255, nullable=true)
     */
    private $apellidoPaterno;

    /**
     * @var string|null
     *
     * @ORM\Column(name="apellido_materno", type="string", length=255, nullable=true)
     */
    private $apellidoMaterno;

    /**
     * @var string|null
     *
     * @ORM\Column(name="rfc", type="string", length=255, nullable=true)
     */
    private $rfc;

    /**
     * @var string|null
     *
     * @ORM\Column(name="curp", type="string", length=255, nullable=true)
     */
    private $curp;

    /**
     * @var string|null
     *
     * @ORM\Column(name="razon_social", type="text", length=65535, nullable=true)
     */
    private $razonSocial;

    /**
     * @var string|null
     *
     * @ORM\Column(name="correo", type="string", length=255, nullable=true)
     */
    private $correo;

    /**
     * @var string|null
     *
     * @ORM\Column(name="telefono", type="string", length=255, nullable=true)
     */
    private $telefono;

    /**
     * @var int
     *
     * @ORM\Column(name="genero", type="integer", nullable=false)
     */
    private $genero = '0';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;



    /**
     * Get idContribuyente.
     *
     * @return int
     */
    public function getIdContribuyente()
    {
        return $this->idContribuyente;
    }

    /**
     * Set idContribuyente.
     *
     * @param bigint|null $idContribuyente
     *
     * @return Contribuyente
     */
    public function setIdContribuyente($idContribuyente)
    {
        $this->idContribuyente = $idContribuyente;
        return $this;
    }

    /**
     * Set cvePersona.
     *
     * @param int|null $cvePersona
     *
     * @return Contribuyente
     */
    public function setCvePersona($cvePersona = null)
    {
        $this->cvePersona = $cvePersona;

        return $this;
    }

    /**
     * Get cvePersona.
     *
     * @return int|null
     */
    public function getCvePersona()
    {
        return $this->cvePersona;
    }

    /**
     * Set nombre.
     *
     * @param string|null $nombre
     *
     * @return Contribuyente
     */
    public function setNombre($nombre = null)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre.
     *
     * @return string|null
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set apellidoPaterno.
     *
     * @param string|null $apellidoPaterno
     *
     * @return Contribuyente
     */
    public function setApellidoPaterno($apellidoPaterno = null)
    {
        $this->apellidoPaterno = $apellidoPaterno;

        return $this;
    }

    /**
     * Get apellidoPaterno.
     *
     * @return string|null
     */
    public function getApellidoPaterno()
    {
        return $this->apellidoPaterno;
    }

    /**
     * Set apellidoMaterno.
     *
     * @param string|null $apellidoMaterno
     *
     * @return Contribuyente
     */
    public function setApellidoMaterno($apellidoMaterno = null)
    {
        $this->apellidoMaterno = $apellidoMaterno;

        return $this;
    }

    /**
     * Get apellidoMaterno.
     *
     * @return string|null
     */
    public function getApellidoMaterno()
    {
        return $this->apellidoMaterno;
    }

    /**
     * Set rfc.
     *
     * @param string|null $rfc
     *
     * @return Contribuyente
     */
    public function setRfc($rfc = null)
    {
        $this->rfc = $rfc;

        return $this;
    }

    /**
     * Get rfc.
     *
     * @return string|null
     */
    public function getRfc()
    {
        return $this->rfc;
    }

    /**
     * Set curp.
     *
     * @param string|null $curp
     *
     * @return Contribuyente
     */
    public function setCurp($curp = null)
    {
        $this->curp = $curp;

        return $this;
    }

    /**
     * Get curp.
     *
     * @return string|null
     */
    public function getCurp()
    {
        return $this->curp;
    }

    /**
     * Set razonSocial.
     *
     * @param string|null $razonSocial
     *
     * @return Contribuyente
     */
    public function setRazonSocial($razonSocial = null)
    {
        $this->razonSocial = $razonSocial;

        return $this;
    }

    /**
     * Get razonSocial.
     *
     * @return string|null
     */
    public function getRazonSocial()
    {
        return $this->razonSocial;
    }

    /**
     * Set correo.
     *
     * @param string|null $correo
     *
     * @return Contribuyente
     */
    public function setCorreo($correo = null)
    {
        $this->correo = $correo;

        return $this;
    }

    /**
     * Get correo.
     *
     * @return string|null
     */
    public function getCorreo()
    {
        return $this->correo;
    }

    /**
     * Set telefono.
     *
     * @param string|null $telefono
     *
     * @return Contribuyente
     */
    public function setTelefono($telefono = null)
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get telefono.
     *
     * @return string|null
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Set genero.
     *
     * @param int $genero
     *
     * @return Contribuyente
     */
    public function setGenero($genero)
    {
        $this->genero = $genero;

        return $this;
    }

    /**
     * Get genero.
     *
     * @return int
     */
    public function getGenero()
    {
        return $this->genero;
    }

    /**
     * Set createdAt.
     *
     * @param \DateTime|null $createdAt
     *
     * @return Contribuyente
     */
    public function setCreatedAt($createdAt = null)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt.
     *
     * @return \DateTime|null
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt.
     *
     * @param \DateTime|null $updatedAt
     *
     * @return Contribuyente
     */
    public function setUpdatedAt($updatedAt = null)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt.
     *
     * @return \DateTime|null
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}
