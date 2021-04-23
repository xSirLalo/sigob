<?php

namespace Catastro\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PredioColindancia
 *
 * @ORM\Table(name="predio_colindancia", indexes={@ORM\Index(name="id_predio", columns={"id_predio"})})
 * @ORM\Entity
 */
class PredioColindancia
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_predio_colindancia", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPredioColindancia;

    /**
     * @var string|null
     *
     * @ORM\Column(name="punto_cardinal", type="string", length=255, nullable=true)
     */
    private $puntoCardinal;

    /**
     * @var float|null
     *
     * @ORM\Column(name="medida_metros_lineales", type="float", precision=10, scale=0, nullable=true)
     */
    private $medidaMetrosLineales;

    /**
     * @var string|null
     *
     * @ORM\Column(name="colindancia", type="string", length=255, nullable=true)
     */
    private $colindancia;

    /**
     * @var string|null
     *
     * @ORM\Column(name="observaciones", type="string", length=255, nullable=true)
     */
    private $observaciones;

    /**
     * @var \Catastro\Entity\Predio
     *
     * @ORM\ManyToOne(targetEntity="Catastro\Entity\Predio")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_predio", referencedColumnName="id_predio")
     * })
     */
    private $idPredio;



    /**
     * Get idPredioColindancia.
     *
     * @return int
     */
    public function getIdPredioColindancia()
    {
        return $this->idPredioColindancia;
    }

    /**
     * Set puntoCardinal.
     *
     * @param string|null $puntoCardinal
     *
     * @return PredioColindancia
     */
    public function setPuntoCardinal($puntoCardinal = null)
    {
        $this->puntoCardinal = $puntoCardinal;

        return $this;
    }

    /**
     * Get puntoCardinal.
     *
     * @return string|null
     */
    public function getPuntoCardinal()
    {
        return $this->puntoCardinal;
    }

    /**
     * Set medidaMetrosLineales.
     *
     * @param float|null $medidaMetrosLineales
     *
     * @return PredioColindancia
     */
    public function setMedidaMetrosLineales($medidaMetrosLineales = null)
    {
        $this->medidaMetrosLineales = $medidaMetrosLineales;

        return $this;
    }

    /**
     * Get medidaMetrosLineales.
     *
     * @return float|null
     */
    public function getMedidaMetrosLineales()
    {
        return $this->medidaMetrosLineales;
    }

    /**
     * Set colindancia.
     *
     * @param string|null $colindancia
     *
     * @return PredioColindancia
     */
    public function setColindancia($colindancia = null)
    {
        $this->colindancia = $colindancia;

        return $this;
    }

    /**
     * Get colindancia.
     *
     * @return string|null
     */
    public function getColindancia()
    {
        return $this->colindancia;
    }

    /**
     * Set observaciones.
     *
     * @param string|null $observaciones
     *
     * @return PredioColindancia
     */
    public function setObservaciones($observaciones = null)
    {
        $this->observaciones = $observaciones;

        return $this;
    }

    /**
     * Get observaciones.
     *
     * @return string|null
     */
    public function getObservaciones()
    {
        return $this->observaciones;
    }

    /**
     * Set idPredio.
     *
     * @param \Catastro\Entity\Predio|null $idPredio
     *
     * @return PredioColindancia
     */
    public function setIdPredio(\Catastro\Entity\Predio $idPredio = null)
    {
        $this->idPredio = $idPredio;

        return $this;
    }

    /**
     * Get idPredio.
     *
     * @return \Catastro\Entity\Predio|null
     */
    public function getIdPredio()
    {
        return $this->idPredio;
    }
}
