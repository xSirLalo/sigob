<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ArchivoCategoria
 *
 * @ORM\Table(name="archivo_categoria")
 * @ORM\Entity
 */
class ArchivoCategoria
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_archivo_categoria", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idArchivoCategoria;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nombre", type="string", length=255, nullable=true)
     */
    private $nombre;



    /**
     * Get idArchivoCategoria.
     *
     * @return int
     */
    public function getIdArchivoCategoria()
    {
        return $this->idArchivoCategoria;
    }

    /**
     * Set nombre.
     *
     * @param string|null $nombre
     *
     * @return ArchivoCategoria
     */
    public function setNombre($nombre = null)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre.
     *
     * @return string|null
     */
    public function getNombre()
    {
        return $this->nombre;
    }
}
