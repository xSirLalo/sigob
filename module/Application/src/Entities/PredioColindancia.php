<?php

namespace Application\Entities;

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
     * @var float|null
     *
     * @ORM\Column(name="medida_metros", type="float", precision=10, scale=0, nullable=true)
     */
    private $medidaMetros;

    /**
     * @var string|null
     *
     * @ORM\Column(name="descripcion", type="string", length=255, nullable=true)
     */
    private $descripcion;

    /**
     * @var string|null
     *
     * @ORM\Column(name="orientacion_geografica", type="string", length=45, nullable=true)
     */
    private $orientacionGeografica;

    /**
     * @var \Application\Entities\Predio
     *
     * @ORM\ManyToOne(targetEntity="Application\Entities\Predio")
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
     * Set medidaMetros.
     *
     * @param float|null $medidaMetros
     *
     * @return PredioColindancia
     */
    public function setMedidaMetros($medidaMetros = null)
    {
        $this->medidaMetros = $medidaMetros;

        return $this;
    }

    /**
     * Get medidaMetros.
     *
     * @return float|null
     */
    public function getMedidaMetros()
    {
        return $this->medidaMetros;
    }

    /**
     * Set descripcion.
     *
     * @param string|null $descripcion
     *
     * @return PredioColindancia
     */
    public function setDescripcion($descripcion = null)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion.
     *
     * @return string|null
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set orientacionGeografica.
     *
     * @param string|null $orientacionGeografica
     *
     * @return PredioColindancia
     */
    public function setOrientacionGeografica($orientacionGeografica = null)
    {
        $this->orientacionGeografica = $orientacionGeografica;

        return $this;
    }

    /**
     * Get orientacionGeografica.
     *
     * @return string|null
     */
    public function getOrientacionGeografica()
    {
        return $this->orientacionGeografica;
    }

    /**
     * Set idPredio.
     *
     * @param \Application\Entities\Predio|null $idPredio
     *
     * @return PredioColindancia
     */
    public function setIdPredio(\Application\Entities\Predio $idPredio = null)
    {
        $this->idPredio = $idPredio;

        return $this;
    }

    /**
     * Get idPredio.
     *
     * @return \Application\Entities\Predio|null
     */
    public function getIdPredio()
    {
        return $this->idPredio;
    }
}
