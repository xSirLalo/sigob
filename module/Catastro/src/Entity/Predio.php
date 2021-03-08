<?php

namespace Catastro\Entity;

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
     * @ORM\Column(name="titular_anterior", type="string", length=255, nullable=true)
     */
    private $titularAnterior;

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
     * @var \Catastro\Entity\Contribuyente
     *
     * @ORM\ManyToOne(targetEntity="Catastro\Entity\Contribuyente")
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
     * Set titularAnterior.
     *
     * @param string|null $titularAnterior
     *
     * @return Predio
     */
    public function setTitularAnterior($titularAnterior = null)
    {
        $this->titularAnterior = $titularAnterior;

        return $this;
    }

    /**
     * Get titularAnterior.
     *
     * @return string|null
     */
    public function getTitularAnterior()
    {
        return $this->titularAnterior;
    }

    /**
     * Set createdAt.
     *
     * @param \DateTime|null $createdAt
     *
     * @return Predio
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
     * @return Predio
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

    /**
     * Set idContribuyente.
     *
     * @param \Catastro\Entity\Contribuyente|null $idContribuyente
     *
     * @return Predio
     */
    public function setIdContribuyente(\Catastro\Entity\Contribuyente $idContribuyente = null)
    {
        $this->idContribuyente = $idContribuyente;

        return $this;
    }

    /**
     * Get idContribuyente.
     *
     * @return \Catastro\Entity\Contribuyente|null
     */
    public function getIdContribuyente()
    {
        return $this->idContribuyente;
    }
}
