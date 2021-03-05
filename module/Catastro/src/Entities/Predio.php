<?php

namespace Catastro\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Predio
 *
 * @ORM\Table(name="predio", indexes={@ORM\Index(name="id_contribuyente", columns={"id_contribuyente"})})
 * @ORM\Entity
 */
class Predio
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_predio", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPredio;

    /**
     * @var string|null
     *
     * @ORM\Column(name="clave_catastral", type="string", length=255, nullable=true)
     */
    private $claveCatastral;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ubicacion", type="string", length=255, nullable=true)
     */
    private $ubicacion;

    /**
     * @var string|null
     *
     * @ORM\Column(name="titular", type="string", length=255, nullable=true)
     */
    private $titular;

    /**
     * @var string|null
     *
     * @ORM\Column(name="titular_anterio", type="string", length=255, nullable=true)
     */
    private $titularAnterio;

    /**
     * @var \Catastro\Entities\Contribuyente
     *
     * @ORM\ManyToOne(targetEntity="Catastro\Entities\Contribuyente")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_contribuyente", referencedColumnName="id_contribuyente")
     * })
     */
    private $idContribuyente;



    /**
     * Get idPredio.
     *
     * @return int
     */
    public function getIdPredio()
    {
        return $this->idPredio;
    }

    /**
     * Set claveCatastral.
     *
     * @param string|null $claveCatastral
     *
     * @return Predio
     */
    public function setClaveCatastral($claveCatastral = null)
    {
        $this->claveCatastral = $claveCatastral;

        return $this;
    }

    /**
     * Get claveCatastral.
     *
     * @return string|null
     */
    public function getClaveCatastral()
    {
        return $this->claveCatastral;
    }

    /**
     * Set ubicacion.
     *
     * @param string|null $ubicacion
     *
     * @return Predio
     */
    public function setUbicacion($ubicacion = null)
    {
        $this->ubicacion = $ubicacion;

        return $this;
    }

    /**
     * Get ubicacion.
     *
     * @return string|null
     */
    public function getUbicacion()
    {
        return $this->ubicacion;
    }

    /**
     * Set titular.
     *
     * @param string|null $titular
     *
     * @return Predio
     */
    public function setTitular($titular = null)
    {
        $this->titular = $titular;

        return $this;
    }

    /**
     * Get titular.
     *
     * @return string|null
     */
    public function getTitular()
    {
        return $this->titular;
    }

    /**
     * Set titularAnterio.
     *
     * @param string|null $titularAnterio
     *
     * @return Predio
     */
    public function setTitularAnterio($titularAnterio = null)
    {
        $this->titularAnterio = $titularAnterio;

        return $this;
    }

    /**
     * Get titularAnterio.
     *
     * @return string|null
     */
    public function getTitularAnterio()
    {
        return $this->titularAnterio;
    }

    /**
     * Set idContribuyente.
     *
     * @param \Catastro\Entities\Contribuyente|null $idContribuyente
     *
     * @return Predio
     */
    public function setIdContribuyente(\Catastro\Entities\Contribuyente $idContribuyente = null)
    {
        $this->idContribuyente = $idContribuyente;

        return $this;
    }

    /**
     * Get idContribuyente.
     *
     * @return \Catastro\Entities\Contribuyente|null
     */
    public function getIdContribuyente()
    {
        return $this->idContribuyente;
    }
}
