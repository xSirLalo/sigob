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
     * @ORM\Column(name="parcela", type="string", length=255, nullable=true)
     */
    private $parcela;

    /**
     * @var string|null
     *
     * @ORM\Column(name="manzana", type="string", length=255, nullable=true)
     */
    private $manzana;

    /**
     * @var string|null
     *
     * @ORM\Column(name="lote", type="string", length=255, nullable=true)
     */
    private $lote;

    /**
     * @var string|null
     *
     * @ORM\Column(name="local", type="string", length=255, nullable=true)
     */
    private $local;

    /**
     * @var string|null
     *
     * @ORM\Column(name="categoria", type="string", length=255, nullable=true)
     */
    private $categoria;

    /**
     * @var string|null
     *
     * @ORM\Column(name="condicion", type="string", length=255, nullable=true)
     */
    private $condicion;

    /**
     * @var string|null
     *
     * @ORM\Column(name="titular", type="string", length=255, nullable=true)
     */
    private $titular;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ubicacion", type="string", length=255, nullable=true)
     */
    private $ubicacion;

    /**
     * @var string|null
     *
     * @ORM\Column(name="localidad", type="string", length=255, nullable=true)
     */
    private $localidad;

    /**
     * @var string|null
     *
     * @ORM\Column(name="antecedentes", type="string", length=255, nullable=true)
     */
    private $antecedentes;

    /**
     * @var string|null
     *
     * @ORM\Column(name="clave_catastral", type="string", length=255, nullable=true)
     */
    private $claveCatastral;

    /**
     * @var string|null
     *
     * @ORM\Column(name="regimen_propiedad", type="string", length=255, nullable=true)
     */
    private $regimenPropiedad;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="fecha_adquicision", type="date", nullable=true)
     */
    private $fechaAdquicision;

    /**
     * @var string|null
     *
     * @ORM\Column(name="titular_anterior", type="string", length=255, nullable=true)
     */
    private $titularAnterior;

    /**
     * @var string|null
     *
     * @ORM\Column(name="documento_propiedad", type="string", length=255, nullable=true)
     */
    private $documentoPropiedad;

    /**
     * @var string|null
     *
     * @ORM\Column(name="folio", type="string", length=255, nullable=true)
     */
    private $folio;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="fecha_documento", type="date", nullable=true)
     */
    private $fechaDocumento;

    /**
     * @var string|null
     *
     * @ORM\Column(name="lote_conflicto", type="string", length=255, nullable=true)
     */
    private $loteConflicto;

    /**
     * @var string|null
     *
     * @ORM\Column(name="observaciones", type="text", length=65535, nullable=true)
     */
    private $observaciones;

    /**
     * @var string|null
     *
     * @ORM\Column(name="colonia", type="string", length=255, nullable=true)
     */
    private $colonia;

    /**
     * @var string|null
     *
     * @ORM\Column(name="municipio", type="string", length=255, nullable=true)
     */
    private $municipio;

    /**
     * @var string|null
     *
     * @ORM\Column(name="calle", type="string", length=255, nullable=true)
     */
    private $calle;

    /**
     * @var string|null
     *
     * @ORM\Column(name="numero_exterior", type="string", length=255, nullable=true)
     */
    private $numeroExterior;

    /**
     * @var string|null
     *
     * @ORM\Column(name="numero_interior", type="string", length=255, nullable=true)
     */
    private $numeroInterior;

    /**
     * @var string|null
     *
     * @ORM\Column(name="tipo", type="string", length=255, nullable=true)
     */
    private $tipo;

    /**
     * @var string|null
     *
     * @ORM\Column(name="estatus", type="string", length=1, nullable=true, options={"fixed"=true})
     */
    private $estatus;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ultimo_ejercicio_pagado", type="string", length=255, nullable=true)
     */
    private $ultimoEjercicioPagado;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ultimo_periodo_pagado", type="string", length=255, nullable=true)
     */
    private $ultimoPeriodoPagado;

    /**
     * @var int|null
     *
     * @ORM\Column(name="cve_predio", type="bigint", nullable=true)
     */
    private $cvePredio;

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
     * Set parcela.
     *
     * @param string|null $parcela
     *
     * @return Predio
     */
    public function setParcela($parcela = null)
    {
        $this->parcela = $parcela;

        return $this;
    }

    /**
     * Get parcela.
     *
     * @return string|null
     */
    public function getParcela()
    {
        return $this->parcela;
    }

    /**
     * Set manzana.
     *
     * @param string|null $manzana
     *
     * @return Predio
     */
    public function setManzana($manzana = null)
    {
        $this->manzana = $manzana;

        return $this;
    }

    /**
     * Get manzana.
     *
     * @return string|null
     */
    public function getManzana()
    {
        return $this->manzana;
    }

    /**
     * Set lote.
     *
     * @param string|null $lote
     *
     * @return Predio
     */
    public function setLote($lote = null)
    {
        $this->lote = $lote;

        return $this;
    }

    /**
     * Get lote.
     *
     * @return string|null
     */
    public function getLote()
    {
        return $this->lote;
    }

    /**
     * Set local.
     *
     * @param string|null $local
     *
     * @return Predio
     */
    public function setLocal($local = null)
    {
        $this->local = $local;

        return $this;
    }

    /**
     * Get local.
     *
     * @return string|null
     */
    public function getLocal()
    {
        return $this->local;
    }

    /**
     * Set categoria.
     *
     * @param string|null $categoria
     *
     * @return Predio
     */
    public function setCategoria($categoria = null)
    {
        $this->categoria = $categoria;

        return $this;
    }

    /**
     * Get categoria.
     *
     * @return string|null
     */
    public function getCategoria()
    {
        return $this->categoria;
    }

    /**
     * Set condicion.
     *
     * @param string|null $condicion
     *
     * @return Predio
     */
    public function setCondicion($condicion = null)
    {
        $this->condicion = $condicion;

        return $this;
    }

    /**
     * Get condicion.
     *
     * @return string|null
     */
    public function getCondicion()
    {
        return $this->condicion;
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
     * Set localidad.
     *
     * @param string|null $localidad
     *
     * @return Predio
     */
    public function setLocalidad($localidad = null)
    {
        $this->localidad = $localidad;

        return $this;
    }

    /**
     * Get localidad.
     *
     * @return string|null
     */
    public function getLocalidad()
    {
        return $this->localidad;
    }

    /**
     * Set antecedentes.
     *
     * @param string|null $antecedentes
     *
     * @return Predio
     */
    public function setAntecedentes($antecedentes = null)
    {
        $this->antecedentes = $antecedentes;

        return $this;
    }

    /**
     * Get antecedentes.
     *
     * @return string|null
     */
    public function getAntecedentes()
    {
        return $this->antecedentes;
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
     * Set regimenPropiedad.
     *
     * @param string|null $regimenPropiedad
     *
     * @return Predio
     */
    public function setRegimenPropiedad($regimenPropiedad = null)
    {
        $this->regimenPropiedad = $regimenPropiedad;

        return $this;
    }

    /**
     * Get regimenPropiedad.
     *
     * @return string|null
     */
    public function getRegimenPropiedad()
    {
        return $this->regimenPropiedad;
    }

    /**
     * Set fechaAdquicision.
     *
     * @param \DateTime|null $fechaAdquicision
     *
     * @return Predio
     */
    public function setFechaAdquicision($fechaAdquicision = null)
    {
        $this->fechaAdquicision = $fechaAdquicision;

        return $this;
    }

    /**
     * Get fechaAdquicision.
     *
     * @return \DateTime|null
     */
    public function getFechaAdquicision()
    {
        return $this->fechaAdquicision;
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
     * Set documentoPropiedad.
     *
     * @param string|null $documentoPropiedad
     *
     * @return Predio
     */
    public function setDocumentoPropiedad($documentoPropiedad = null)
    {
        $this->documentoPropiedad = $documentoPropiedad;

        return $this;
    }

    /**
     * Get documentoPropiedad.
     *
     * @return string|null
     */
    public function getDocumentoPropiedad()
    {
        return $this->documentoPropiedad;
    }

    /**
     * Set folio.
     *
     * @param string|null $folio
     *
     * @return Predio
     */
    public function setFolio($folio = null)
    {
        $this->folio = $folio;

        return $this;
    }

    /**
     * Get folio.
     *
     * @return string|null
     */
    public function getFolio()
    {
        return $this->folio;
    }

    /**
     * Set fechaDocumento.
     *
     * @param \DateTime|null $fechaDocumento
     *
     * @return Predio
     */
    public function setFechaDocumento($fechaDocumento = null)
    {
        $this->fechaDocumento = $fechaDocumento;

        return $this;
    }

    /**
     * Get fechaDocumento.
     *
     * @return \DateTime|null
     */
    public function getFechaDocumento()
    {
        return $this->fechaDocumento;
    }

    /**
     * Set loteConflicto.
     *
     * @param string|null $loteConflicto
     *
     * @return Predio
     */
    public function setLoteConflicto($loteConflicto = null)
    {
        $this->loteConflicto = $loteConflicto;

        return $this;
    }

    /**
     * Get loteConflicto.
     *
     * @return string|null
     */
    public function getLoteConflicto()
    {
        return $this->loteConflicto;
    }

    /**
     * Set observaciones.
     *
     * @param string|null $observaciones
     *
     * @return Predio
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
     * Set colonia.
     *
     * @param string|null $colonia
     *
     * @return Predio
     */
    public function setColonia($colonia = null)
    {
        $this->colonia = $colonia;

        return $this;
    }

    /**
     * Get colonia.
     *
     * @return string|null
     */
    public function getColonia()
    {
        return $this->colonia;
    }

    /**
     * Set municipio.
     *
     * @param string|null $municipio
     *
     * @return Predio
     */
    public function setMunicipio($municipio = null)
    {
        $this->municipio = $municipio;

        return $this;
    }

    /**
     * Get municipio.
     *
     * @return string|null
     */
    public function getMunicipio()
    {
        return $this->municipio;
    }

    /**
     * Set calle.
     *
     * @param string|null $calle
     *
     * @return Predio
     */
    public function setCalle($calle = null)
    {
        $this->calle = $calle;

        return $this;
    }

    /**
     * Get calle.
     *
     * @return string|null
     */
    public function getCalle()
    {
        return $this->calle;
    }

    /**
     * Set numeroExterior.
     *
     * @param string|null $numeroExterior
     *
     * @return Predio
     */
    public function setNumeroExterior($numeroExterior = null)
    {
        $this->numeroExterior = $numeroExterior;

        return $this;
    }

    /**
     * Get numeroExterior.
     *
     * @return string|null
     */
    public function getNumeroExterior()
    {
        return $this->numeroExterior;
    }

    /**
     * Set numeroInterior.
     *
     * @param string|null $numeroInterior
     *
     * @return Predio
     */
    public function setNumeroInterior($numeroInterior = null)
    {
        $this->numeroInterior = $numeroInterior;

        return $this;
    }

    /**
     * Get numeroInterior.
     *
     * @return string|null
     */
    public function getNumeroInterior()
    {
        return $this->numeroInterior;
    }

    /**
     * Set tipo.
     *
     * @param string|null $tipo
     *
     * @return Predio
     */
    public function setTipo($tipo = null)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo.
     *
     * @return string|null
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set estatus.
     *
     * @param string|null $estatus
     *
     * @return Predio
     */
    public function setEstatus($estatus = null)
    {
        $this->estatus = $estatus;

        return $this;
    }

    /**
     * Get estatus.
     *
     * @return string|null
     */
    public function getEstatus()
    {
        return $this->estatus;
    }

    /**
     * Set ultimoEjercicioPagado.
     *
     * @param string|null $ultimoEjercicioPagado
     *
     * @return Predio
     */
    public function setUltimoEjercicioPagado($ultimoEjercicioPagado = null)
    {
        $this->ultimoEjercicioPagado = $ultimoEjercicioPagado;

        return $this;
    }

    /**
     * Get ultimoEjercicioPagado.
     *
     * @return string|null
     */
    public function getUltimoEjercicioPagado()
    {
        return $this->ultimoEjercicioPagado;
    }

    /**
     * Set ultimoPeriodoPagado.
     *
     * @param string|null $ultimoPeriodoPagado
     *
     * @return Predio
     */
    public function setUltimoPeriodoPagado($ultimoPeriodoPagado = null)
    {
        $this->ultimoPeriodoPagado = $ultimoPeriodoPagado;

        return $this;
    }

    /**
     * Get ultimoPeriodoPagado.
     *
     * @return string|null
     */
    public function getUltimoPeriodoPagado()
    {
        return $this->ultimoPeriodoPagado;
    }

    /**
     * Set cvePredio.
     *
     * @param int|null $cvePredio
     *
     * @return Predio
     */
    public function setCvePredio($cvePredio = null)
    {
        $this->cvePredio = $cvePredio;

        return $this;
    }

    /**
     * Get cvePredio.
     *
     * @return int|null
     */
    public function getCvePredio()
    {
        return $this->cvePredio;
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
