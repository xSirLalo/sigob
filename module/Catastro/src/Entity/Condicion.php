<?php

namespace Catastro\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Condicion
 *
 * @ORM\Table(name="condicion")
 * @ORM\Entity
 */
class Condicion
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_condicion", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idCondicion;

    /**
     * @var string|null
     *
     * @ORM\Column(name="tipo_condicion", type="string", length=255, nullable=true)
     */
    private $tipoCondicion;



    /**
     * Get idCondicion.
     *
     * @return int
     */
    public function getIdCondicion()
    {
        return $this->idCondicion;
    }

    /**
     * Set tipoCondicion.
     *
     * @param string|null $tipoCondicion
     *
     * @return Condicion
     */
    public function setTipoCondicion($tipoCondicion = null)
    {
        $this->tipoCondicion = $tipoCondicion;

        return $this;
    }

    /**
     * Get tipoCondicion.
     *
     * @return string|null
     */
    public function getTipoCondicion()
    {
        return $this->tipoCondicion;
    }
}
