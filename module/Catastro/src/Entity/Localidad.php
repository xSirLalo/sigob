<?php

namespace Catastro\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Localidad
 *
 * @ORM\Table(name="localidad")
 * @ORM\Entity
 */
class Localidad
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_localidad", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idLocalidad;

    /**
     * @var int|null
     *
     * @ORM\Column(name="cve_distrito", type="integer", nullable=true)
     */
    private $cveDistrito;

    /**
     * @var int|null
     *
     * @ORM\Column(name="cve_entidad_federativa", type="integer", nullable=true)
     */
    private $cveEntidadFederativa;

    /**
     * @var int|null
     *
     * @ORM\Column(name="cve_localidad", type="integer", nullable=true)
     */
    private $cveLocalidad;

    /**
     * @var int|null
     *
     * @ORM\Column(name="cve_municipio", type="integer", nullable=true)
     */
    private $cveMunicipio;

    /**
     * @var int|null
     *
     * @ORM\Column(name="cve_region", type="integer", nullable=true)
     */
    private $cveRegion;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nombre_localidad", type="string", length=255, nullable=true)
     */
    private $nombreLocalidad;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nombre_oficial_localidad", type="string", length=255, nullable=true)
     */
    private $nombreOficialLocalidad;



    /**
     * Get idLocalidad.
     *
     * @return int
     */
    public function getIdLocalidad()
    {
        return $this->idLocalidad;
    }

    /**
     * Set cveDistrito.
     *
     * @param int|null $cveDistrito
     *
     * @return Localidad
     */
    public function setCveDistrito($cveDistrito = null)
    {
        $this->cveDistrito = $cveDistrito;

        return $this;
    }

    /**
     * Get cveDistrito.
     *
     * @return int|null
     */
    public function getCveDistrito()
    {
        return $this->cveDistrito;
    }

    /**
     * Set cveEntidadFederativa.
     *
     * @param int|null $cveEntidadFederativa
     *
     * @return Localidad
     */
    public function setCveEntidadFederativa($cveEntidadFederativa = null)
    {
        $this->cveEntidadFederativa = $cveEntidadFederativa;

        return $this;
    }

    /**
     * Get cveEntidadFederativa.
     *
     * @return int|null
     */
    public function getCveEntidadFederativa()
    {
        return $this->cveEntidadFederativa;
    }

    /**
     * Set cveLocalidad.
     *
     * @param int|null $cveLocalidad
     *
     * @return Localidad
     */
    public function setCveLocalidad($cveLocalidad = null)
    {
        $this->cveLocalidad = $cveLocalidad;

        return $this;
    }

    /**
     * Get cveLocalidad.
     *
     * @return int|null
     */
    public function getCveLocalidad()
    {
        return $this->cveLocalidad;
    }

    /**
     * Set cveMunicipio.
     *
     * @param int|null $cveMunicipio
     *
     * @return Localidad
     */
    public function setCveMunicipio($cveMunicipio = null)
    {
        $this->cveMunicipio = $cveMunicipio;

        return $this;
    }

    /**
     * Get cveMunicipio.
     *
     * @return int|null
     */
    public function getCveMunicipio()
    {
        return $this->cveMunicipio;
    }

    /**
     * Set cveRegion.
     *
     * @param int|null $cveRegion
     *
     * @return Localidad
     */
    public function setCveRegion($cveRegion = null)
    {
        $this->cveRegion = $cveRegion;

        return $this;
    }

    /**
     * Get cveRegion.
     *
     * @return int|null
     */
    public function getCveRegion()
    {
        return $this->cveRegion;
    }

    /**
     * Set nombreLocalidad.
     *
     * @param string|null $nombreLocalidad
     *
     * @return Localidad
     */
    public function setNombreLocalidad($nombreLocalidad = null)
    {
        $this->nombreLocalidad = $nombreLocalidad;

        return $this;
    }

    /**
     * Get nombreLocalidad.
     *
     * @return string|null
     */
    public function getNombreLocalidad()
    {
        return $this->nombreLocalidad;
    }

    /**
     * Set nombreOficialLocalidad.
     *
     * @param string|null $nombreOficialLocalidad
     *
     * @return Localidad
     */
    public function setNombreOficialLocalidad($nombreOficialLocalidad = null)
    {
        $this->nombreOficialLocalidad = $nombreOficialLocalidad;

        return $this;
    }

    /**
     * Get nombreOficialLocalidad.
     *
     * @return string|null
     */
    public function getNombreOficialLocalidad()
    {
        return $this->nombreOficialLocalidad;
    }
}
