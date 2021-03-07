<?php

namespace Catastro\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Aportacion
 *
 * @ORM\Table(name="aportacion", indexes={@ORM\Index(name="id_predio", columns={"id_predio"}), @ORM\Index(name="id_contribuyente", columns={"id_contribuyente"})})
 * @ORM\Entity
 */
class Aportacion
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_aportacion", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idAportacion;

    /**
     * @var float|null
     *
     * @ORM\Column(name="pago", type="float", precision=10, scale=0, nullable=true)
     */
    private $pago;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="fecha", type="date", nullable=true)
     */
    private $fecha;

    /**
     * @var float|null
     *
     * @ORM\Column(name="metros_terreno", type="float", precision=10, scale=0, nullable=true)
     */
    private $metrosTerreno;

    /**
     * @var float|null
     *
     * @ORM\Column(name="metros_construccion", type="float", precision=10, scale=0, nullable=true)
     */
    private $metrosConstruccion;

    /**
     * @var float|null
     *
     * @ORM\Column(name="valor_terreno", type="float", precision=10, scale=0, nullable=true)
     */
    private $valorTerreno;

    /**
     * @var float|null
     *
     * @ORM\Column(name="valor_construccion", type="float", precision=10, scale=0, nullable=true)
     */
    private $valorConstruccion;

    /**
     * @var float|null
     *
     * @ORM\Column(name="avaluo", type="float", precision=10, scale=0, nullable=true)
     */
    private $avaluo;

    /**
     * @var int|null
     *
     * @ORM\Column(name="estatus", type="integer", nullable=true)
     */
    private $estatus;

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
     * @var \Catastro\Entity\Predio
     *
     * @ORM\ManyToOne(targetEntity="Catastro\Entity\Predio")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_predio", referencedColumnName="id_predio")
     * })
     */
    private $idPredio;



    /**
     * Get idAportacion.
     *
     * @return int
     */
    public function getIdAportacion()
    {
        return $this->idAportacion;
    }

    /**
     * Set pago.
     *
     * @param float|null $pago
     *
     * @return Aportacion
     */
    public function setPago($pago = null)
    {
        $this->pago = $pago;

        return $this;
    }

    /**
     * Get pago.
     *
     * @return float|null
     */
    public function getPago()
    {
        return $this->pago;
    }

    /**
     * Set fecha.
     *
     * @param \DateTime|null $fecha
     *
     * @return Aportacion
     */
    public function setFecha($fecha = null)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha.
     *
     * @return \DateTime|null
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set metrosTerreno.
     *
     * @param float|null $metrosTerreno
     *
     * @return Aportacion
     */
    public function setMetrosTerreno($metrosTerreno = null)
    {
        $this->metrosTerreno = $metrosTerreno;

        return $this;
    }

    /**
     * Get metrosTerreno.
     *
     * @return float|null
     */
    public function getMetrosTerreno()
    {
        return $this->metrosTerreno;
    }

    /**
     * Set metrosConstruccion.
     *
     * @param float|null $metrosConstruccion
     *
     * @return Aportacion
     */
    public function setMetrosConstruccion($metrosConstruccion = null)
    {
        $this->metrosConstruccion = $metrosConstruccion;

        return $this;
    }

    /**
     * Get metrosConstruccion.
     *
     * @return float|null
     */
    public function getMetrosConstruccion()
    {
        return $this->metrosConstruccion;
    }

    /**
     * Set valorTerreno.
     *
     * @param float|null $valorTerreno
     *
     * @return Aportacion
     */
    public function setValorTerreno($valorTerreno = null)
    {
        $this->valorTerreno = $valorTerreno;

        return $this;
    }

    /**
     * Get valorTerreno.
     *
     * @return float|null
     */
    public function getValorTerreno()
    {
        return $this->valorTerreno;
    }

    /**
     * Set valorConstruccion.
     *
     * @param float|null $valorConstruccion
     *
     * @return Aportacion
     */
    public function setValorConstruccion($valorConstruccion = null)
    {
        $this->valorConstruccion = $valorConstruccion;

        return $this;
    }

    /**
     * Get valorConstruccion.
     *
     * @return float|null
     */
    public function getValorConstruccion()
    {
        return $this->valorConstruccion;
    }

    /**
     * Set avaluo.
     *
     * @param float|null $avaluo
     *
     * @return Aportacion
     */
    public function setAvaluo($avaluo = null)
    {
        $this->avaluo = $avaluo;

        return $this;
    }

    /**
     * Get avaluo.
     *
     * @return float|null
     */
    public function getAvaluo()
    {
        return $this->avaluo;
    }

    /**
     * Set estatus.
     *
     * @param int|null $estatus
     *
     * @return Aportacion
     */
    public function setEstatus($estatus = null)
    {
        $this->estatus = $estatus;

        return $this;
    }

    /**
     * Get estatus.
     *
     * @return int|null
     */
    public function getEstatus()
    {
        return $this->estatus;
    }

    /**
     * Set idContribuyente.
     *
     * @param \Catastro\Entity\Contribuyente|null $idContribuyente
     *
     * @return Aportacion
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

    /**
     * Set idPredio.
     *
     * @param \Catastro\Entity\Predio|null $idPredio
     *
     * @return Aportacion
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
