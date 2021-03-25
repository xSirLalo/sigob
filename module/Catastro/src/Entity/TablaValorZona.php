<?php

namespace Catastro\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TablaValorZona
 *
 * @ORM\Table(name="tabla_valor_zona")
 * @ORM\Entity
 */
class TablaValorZona
{
    /**
     * @var int
     *
     * @ORM\Column(name="tabla_valor_zona", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $tablaValorZona;

    /**
     * @var string|null
     *
     * @ORM\Column(name="sector", type="string", length=255, nullable=true)
     */
    private $sector;

    /**
     * @var float|null
     *
     * @ORM\Column(name="valor_zona", type="float", precision=10, scale=0, nullable=true)
     */
    private $valorZona;

    /**
     * @var string|null
     *
     * @ORM\Column(name="limites", type="string", length=255, nullable=true)
     */
    private $limites;

    /**
     * @var string|null
     *
     * @ORM\Column(name="grupo", type="string", length=255, nullable=true)
     */
    private $grupo;



    /**
     * Get tablaValorZona.
     *
     * @return int
     */
    public function getTablaValorZona()
    {
        return $this->tablaValorZona;
    }

    /**
     * Set sector.
     *
     * @param string|null $sector
     *
     * @return TablaValorZona
     */
    public function setSector($sector = null)
    {
        $this->sector = $sector;

        return $this;
    }

    /**
     * Get sector.
     *
     * @return string|null
     */
    public function getSector()
    {
        return $this->sector;
    }

    /**
     * Set valorZona.
     *
     * @param float|null $valorZona
     *
     * @return TablaValorZona
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
     * Set limites.
     *
     * @param string|null $limites
     *
     * @return TablaValorZona
     */
    public function setLimites($limites = null)
    {
        $this->limites = $limites;

        return $this;
    }

    /**
     * Get limites.
     *
     * @return string|null
     */
    public function getLimites()
    {
        return $this->limites;
    }

    /**
     * Set grupo.
     *
     * @param string|null $grupo
     *
     * @return TablaValorZona
     */
    public function setGrupo($grupo = null)
    {
        $this->grupo = $grupo;

        return $this;
    }

    /**
     * Get grupo.
     *
     * @return string|null
     */
    public function getGrupo()
    {
        return $this->grupo;
    }
}
