<?php

namespace Application\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * TablaValorConstruccion
 *
 * @ORM\Table(name="tabla_valor_construccion")
 * @ORM\Entity
 */
class TablaValorConstruccion
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_tabla_valor_construccion", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idTablaValorConstruccion;

    /**
     * @var string|null
     *
     * @ORM\Column(name="grupo", type="string", length=255, nullable=true)
     */
    private $grupo;

    /**
     * @var string|null
     *
     * @ORM\Column(name="caracteristicas", type="string", length=255, nullable=true)
     */
    private $caracteristicas;

    /**
     * @var float|null
     *
     * @ORM\Column(name="costo", type="float", precision=10, scale=0, nullable=true)
     */
    private $costo;



    /**
     * Get idTablaValorConstruccion.
     *
     * @return int
     */
    public function getIdTablaValorConstruccion()
    {
        return $this->idTablaValorConstruccion;
    }

    /**
     * Set grupo.
     *
     * @param string|null $grupo
     *
     * @return TablaValorConstruccion
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

    /**
     * Set caracteristicas.
     *
     * @param string|null $caracteristicas
     *
     * @return TablaValorConstruccion
     */
    public function setCaracteristicas($caracteristicas = null)
    {
        $this->caracteristicas = $caracteristicas;

        return $this;
    }

    /**
     * Get caracteristicas.
     *
     * @return string|null
     */
    public function getCaracteristicas()
    {
        return $this->caracteristicas;
    }

    /**
     * Set costo.
     *
     * @param float|null $costo
     *
     * @return TablaValorConstruccion
     */
    public function setCosto($costo = null)
    {
        $this->costo = $costo;

        return $this;
    }

    /**
     * Get costo.
     *
     * @return float|null
     */
    public function getCosto()
    {
        return $this->costo;
    }
}
