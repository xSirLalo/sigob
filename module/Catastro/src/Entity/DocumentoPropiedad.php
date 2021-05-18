<?php

namespace Catastro\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DocumentoPropiedad
 *
 * @ORM\Table(name="documento_propiedad")
 * @ORM\Entity
 */
class DocumentoPropiedad
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_documento_propiedad", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idDocumentoPropiedad;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nombre_documento_propiedad", type="string", length=255, nullable=true)
     */
    private $nombreDocumentoPropiedad;



    /**
     * Get idDocumentoPropiedad.
     *
     * @return int
     */
    public function getIdDocumentoPropiedad()
    {
        return $this->idDocumentoPropiedad;
    }

    /**
     * Set nombreDocumentoPropiedad.
     *
     * @param string|null $nombreDocumentoPropiedad
     *
     * @return DocumentoPropiedad
     */
    public function setNombreDocumentoPropiedad($nombreDocumentoPropiedad = null)
    {
        $this->nombreDocumentoPropiedad = $nombreDocumentoPropiedad;

        return $this;
    }

    /**
     * Get nombreDocumentoPropiedad.
     *
     * @return string|null
     */
    public function getNombreDocumentoPropiedad()
    {
        return $this->nombreDocumentoPropiedad;
    }
}
