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
     * @var int|null
     *
     * @ORM\Column(name="estatus", type="integer", nullable=true)
     */
    private $estatus;

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
     * @ORM\Column(name="valor_zona", type="float", precision=10, scale=0, nullable=true)
     */
    private $valorZona;

    /**
     * @var float|null
     *
     * @ORM\Column(name="valor_terreno", type="float", precision=10, scale=0, nullable=true)
     */
    private $valorTerreno;

    /**
     * @var float|null
     *
     * @ORM\Column(name="metros_construccion", type="float", precision=10, scale=0, nullable=true)
     */
    private $metrosConstruccion;

    /**
     * @var float|null
     *
     * @ORM\Column(name="valor_mts_construccion", type="float", precision=10, scale=0, nullable=true)
     */
    private $valorMtsConstruccion;

    /**
     * @var float|null
     *
     * @ORM\Column(name="valor_construccion", type="float", precision=10, scale=0, nullable=true)
     */
    private $valorConstruccion;

    /**
     * @var int|null
     *
     * @ORM\Column(name="ejercicio_fiscal", type="integer", nullable=true)
     */
    private $ejercicioFiscal;

    /**
     * @var float|null
     *
     * @ORM\Column(name="tasa", type="float", precision=10, scale=0, nullable=true)
     */
    private $tasa;

    /**
     * @var float|null
     *
     * @ORM\Column(name="avaluo", type="float", precision=10, scale=0, nullable=true)
     */
    private $avaluo;

    /**
     * @var float|null
     *
     * @ORM\Column(name="pago", type="float", precision=10, scale=0, nullable=true)
     */
    private $pago;

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
     * Set valorZona.
     *
     * @param float|null $valorZona
     *
     * @return Aportacion
     */
    public function setValorZona($valorZona = null)
    {
        $this->valorZona = $valorZona;

        return $this;
    }

    /**
     * Get valorZona.
     *
     * @return float|null
     */
    public function getValorZona()
    {
        return $this->valorZona;
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
     * Set valorMtsConstruccion.
     *
     * @param float|null $valorMtsConstruccion
     *
     * @return Aportacion
     */
    public function setValorMtsConstruccion($valorMtsConstruccion = null)
    {
        $this->valorMtsConstruccion = $valorMtsConstruccion;

        return $this;
    }

    /**
     * Get valorMtsConstruccion.
     *
     * @return float|null
     */
    public function getValorMtsConstruccion()
    {
        return $this->valorMtsConstruccion;
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
     * Set ejercicioFiscal.
     *
     * @param int|null $ejercicioFiscal
     *
     * @return Aportacion
     */
    public function setEjercicioFiscal($ejercicioFiscal = null)
    {
        $this->ejercicioFiscal = $ejercicioFiscal;

        return $this;
    }

    /**
     * Get ejercicioFiscal.
     *
     * @return int|null
     */
    public function getEjercicioFiscal()
    {
        return $this->ejercicioFiscal;
    }

    /**
     * Set tasa.
     *
     * @param float|null $tasa
     *
     * @return Aportacion
     */
    public function setTasa($tasa = null)
    {
        $this->tasa = $tasa;

        return $this;
    }

    /**
     * Get tasa.
     *
     * @return float|null
     */
    public function getTasa()
    {
        return $this->tasa;
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
     * Set createdAt.
     *
     * @param \DateTime|null $createdAt
     *
     * @return Aportacion
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
     * @return Aportacion
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
