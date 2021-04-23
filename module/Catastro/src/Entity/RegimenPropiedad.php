<?php

namespace Catastro\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RegimenPropiedad
 *
 * @ORM\Table(name="regimen_propiedad")
 * @ORM\Entity
 */
class RegimenPropiedad
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_regimen_propiedad", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idRegimenPropiedad;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nombre_regimen_propiedad", type="string", length=255, nullable=true)
     */
    private $nombreRegimenPropiedad;



    /**
     * Get idRegimenPropiedad.
     *
     * @return int
     */
    public function getIdRegimenPropiedad()
    {
        return $this->idRegimenPropiedad;
    }

    /**
     * Set nombreRegimenPropiedad.
     *
     * @param string|null $nombreRegimenPropiedad
     *
     * @return RegimenPropiedad
     */
    public function setNombreRegimenPropiedad($nombreRegimenPropiedad = null)
    {
        $this->nombreRegimenPropiedad = $nombreRegimenPropiedad;

        return $this;
    }

    /**
     * Get nombreRegimenPropiedad.
     *
     * @return string|null
     */
    public function getNombreRegimenPropiedad()
    {
        return $this->nombreRegimenPropiedad;
    }
}
