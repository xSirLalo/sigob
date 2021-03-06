<?php

namespace Application\Entities;

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
     * @var int
     *
     * @ORM\Column(name="genero", type="integer", nullable=false)
     */
    private $genero = '0';



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
}
