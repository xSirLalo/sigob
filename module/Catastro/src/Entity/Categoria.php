<?php

namespace Catastro\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Categoria
 *
 * @ORM\Table(name="categoria")
 * @ORM\Entity
 */
class Categoria
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_categoria", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idCategoria;

    /**
     * @var string|null
     *
     * @ORM\Column(name="tipo_categoria", type="string", length=255, nullable=true)
     */
    private $tipoCategoria;



    /**
     * Get idCategoria.
     *
     * @return int
     */
    public function getIdCategoria()
    {
        return $this->idCategoria;
    }

    /**
     * Set tipoCategoria.
     *
     * @param string|null $tipoCategoria
     *
     * @return Categoria
     */
    public function setTipoCategoria($tipoCategoria = null)
    {
        $this->tipoCategoria = $tipoCategoria;

        return $this;
    }

    /**
     * Get tipoCategoria.
     *
     * @return string|null
     */
    public function getTipoCategoria()
    {
        return $this->tipoCategoria;
    }
}
