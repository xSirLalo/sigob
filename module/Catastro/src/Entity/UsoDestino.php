<?php

namespace Catastro\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UsoDestino
 *
 * @ORM\Table(name="uso_destino")
 * @ORM\Entity
 */
class UsoDestino
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_uso_destino", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idUsoDestino;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nombre_uso_destino", type="string", length=255, nullable=true)
     */
    private $nombreUsoDestino;



    /**
     * Get idUsoDestino.
     *
     * @return int
     */
    public function getIdUsoDestino()
    {
        return $this->idUsoDestino;
    }

    /**
     * Set nombreUsoDestino.
     *
     * @param string|null $nombreUsoDestino
     *
     * @return UsoDestino
     */
    public function setNombreUsoDestino($nombreUsoDestino = null)
    {
        $this->nombreUsoDestino = $nombreUsoDestino;

        return $this;
    }

    /**
     * Get nombreUsoDestino.
     *
     * @return string|null
     */
    public function getNombreUsoDestino()
    {
        return $this->nombreUsoDestino;
    }
}
