<?php

namespace Catastro\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GiroComercial
 *
 * @ORM\Table(name="giro_comercial")
 * @ORM\Entity
 */
class GiroComercial
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_giro_comercial", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idGiroComercial;

    /**
     * @var string|null
     *
     * @ORM\Column(name="cve_ftm_mt", type="string", length=255, nullable=true)
     */
    private $cveFtmMt;

    /**
     * @var string|null
     *
     * @ORM\Column(name="giro_comercial_descripcion", type="string", length=255, nullable=true)
     */
    private $giroComercialDescripcion;

    /**
     * @var float|null
     *
     * @ORM\Column(name="tarifas_licencias_basura_cve_fte_ing_basura", type="float", precision=10, scale=0, nullable=true)
     */
    private $tarifasLicenciasBasuraCveFteIngBasura;

    /**
     * @var float|null
     *
     * @ORM\Column(name="tarifas_licencias_basura_cve_fte_ing_licencia", type="float", precision=10, scale=0, nullable=true)
     */
    private $tarifasLicenciasBasuraCveFteIngLicencia;

    /**
     * @var float|null
     *
     * @ORM\Column(name="tarifas_licencias_basura_importe_basura", type="float", precision=10, scale=0, nullable=true)
     */
    private $tarifasLicenciasBasuraImporteBasura;

    /**
     * @var float|null
     *
     * @ORM\Column(name="tarifas_licencias_basura_importe_licencia", type="float", precision=10, scale=0, nullable=true)
     */
    private $tarifasLicenciasBasuraImporteLicencia;



    /**
     * Get idGiroComercial.
     *
     * @return int
     */
    public function getIdGiroComercial()
    {
        return $this->idGiroComercial;
    }

    /**
     * Set cveFtmMt.
     *
     * @param string|null $cveFtmMt
     *
     * @return GiroComercial
     */
    public function setCveFtmMt($cveFtmMt = null)
    {
        $this->cveFtmMt = $cveFtmMt;

        return $this;
    }

    /**
     * Get cveFtmMt.
     *
     * @return string|null
     */
    public function getCveFtmMt()
    {
        return $this->cveFtmMt;
    }

    /**
     * Set giroComercialDescripcion.
     *
     * @param string|null $giroComercialDescripcion
     *
     * @return GiroComercial
     */
    public function setGiroComercialDescripcion($giroComercialDescripcion = null)
    {
        $this->giroComercialDescripcion = $giroComercialDescripcion;

        return $this;
    }

    /**
     * Get giroComercialDescripcion.
     *
     * @return string|null
     */
    public function getGiroComercialDescripcion()
    {
        return $this->giroComercialDescripcion;
    }

    /**
     * Set tarifasLicenciasBasuraCveFteIngBasura.
     *
     * @param float|null $tarifasLicenciasBasuraCveFteIngBasura
     *
     * @return GiroComercial
     */
    public function setTarifasLicenciasBasuraCveFteIngBasura($tarifasLicenciasBasuraCveFteIngBasura = null)
    {
        $this->tarifasLicenciasBasuraCveFteIngBasura = $tarifasLicenciasBasuraCveFteIngBasura;

        return $this;
    }

    /**
     * Get tarifasLicenciasBasuraCveFteIngBasura.
     *
     * @return float|null
     */
    public function getTarifasLicenciasBasuraCveFteIngBasura()
    {
        return $this->tarifasLicenciasBasuraCveFteIngBasura;
    }

    /**
     * Set tarifasLicenciasBasuraCveFteIngLicencia.
     *
     * @param float|null $tarifasLicenciasBasuraCveFteIngLicencia
     *
     * @return GiroComercial
     */
    public function setTarifasLicenciasBasuraCveFteIngLicencia($tarifasLicenciasBasuraCveFteIngLicencia = null)
    {
        $this->tarifasLicenciasBasuraCveFteIngLicencia = $tarifasLicenciasBasuraCveFteIngLicencia;

        return $this;
    }

    /**
     * Get tarifasLicenciasBasuraCveFteIngLicencia.
     *
     * @return float|null
     */
    public function getTarifasLicenciasBasuraCveFteIngLicencia()
    {
        return $this->tarifasLicenciasBasuraCveFteIngLicencia;
    }

    /**
     * Set tarifasLicenciasBasuraImporteBasura.
     *
     * @param float|null $tarifasLicenciasBasuraImporteBasura
     *
     * @return GiroComercial
     */
    public function setTarifasLicenciasBasuraImporteBasura($tarifasLicenciasBasuraImporteBasura = null)
    {
        $this->tarifasLicenciasBasuraImporteBasura = $tarifasLicenciasBasuraImporteBasura;

        return $this;
    }

    /**
     * Get tarifasLicenciasBasuraImporteBasura.
     *
     * @return float|null
     */
    public function getTarifasLicenciasBasuraImporteBasura()
    {
        return $this->tarifasLicenciasBasuraImporteBasura;
    }

    /**
     * Set tarifasLicenciasBasuraImporteLicencia.
     *
     * @param float|null $tarifasLicenciasBasuraImporteLicencia
     *
     * @return GiroComercial
     */
    public function setTarifasLicenciasBasuraImporteLicencia($tarifasLicenciasBasuraImporteLicencia = null)
    {
        $this->tarifasLicenciasBasuraImporteLicencia = $tarifasLicenciasBasuraImporteLicencia;

        return $this;
    }

    /**
     * Get tarifasLicenciasBasuraImporteLicencia.
     *
     * @return float|null
     */
    public function getTarifasLicenciasBasuraImporteLicencia()
    {
        return $this->tarifasLicenciasBasuraImporteLicencia;
    }
}
