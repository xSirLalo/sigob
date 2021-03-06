<?php

namespace Catastro\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LoteConflicto
 *
 * @ORM\Table(name="lote_conflicto")
 * @ORM\Entity
 */
class LoteConflicto
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_lote_conflicto", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idLoteConflicto;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nombre_lote_conflicto", type="string", length=255, nullable=true)
     */
    private $nombreLoteConflicto;



    /**
     * Get idLoteConflicto.
     *
     * @return int
     */
    public function getIdLoteConflicto()
    {
        return $this->idLoteConflicto;
    }

    /**
     * Set nombreLoteConflicto.
     *
     * @param string|null $nombreLoteConflicto
     *
     * @return LoteConflicto
     */
    public function setNombreLoteConflicto($nombreLoteConflicto = null)
    {
        $this->nombreLoteConflicto = $nombreLoteConflicto;

        return $this;
    }

    /**
     * Get nombreLoteConflicto.
     *
     * @return string|null
     */
    public function getNombreLoteConflicto()
    {
        return $this->nombreLoteConflicto;
    }
}
