<?php

namespace Catastro\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Archivo
 *
 * @ORM\Table(name="archivo", indexes={@ORM\Index(name="id_archivo_categoria", columns={"id_archivo_categoria"})})
 * @ORM\Entity
 */
class Archivo
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_archivo", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idArchivo;

    /**
     * @var string|null
     *
     * @ORM\Column(name="file", type="blob", length=0, nullable=true)
     */
    private $file;

    /**
     * @var string|null
     *
     * @ORM\Column(name="extension", type="string", length=255, nullable=true)
     */
    private $extension;

    /**
     * @var string|null
     *
     * @ORM\Column(name="size", type="string", length=225, nullable=true)
     */
    private $size;

    /**
     * @var string|null
     *
     * @ORM\Column(name="url", type="string", length=255, nullable=true)
     */
    private $url;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @var \Catastro\Entity\ArchivoCategoria
     *
     * @ORM\ManyToOne(targetEntity="Catastro\Entity\ArchivoCategoria")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_archivo_categoria", referencedColumnName="id_archivo_categoria")
     * })
     */
    private $idArchivoCategoria;



    /**
     * Get idArchivo.
     *
     * @return int
     */
    public function getIdArchivo()
    {
        return $this->idArchivo;
    }

    /**
     * Set file.
     *
     * @param string|null $file
     *
     * @return Archivo
     */
    public function setFile($file = null)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Get file.
     *
     * @return string|null
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Set extension.
     *
     * @param string|null $extension
     *
     * @return Archivo
     */
    public function setExtension($extension = null)
    {
        $this->extension = $extension;

        return $this;
    }

    /**
     * Get extension.
     *
     * @return string|null
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * Set size.
     *
     * @param string|null $size
     *
     * @return Archivo
     */
    public function setSize($size = null)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Get size.
     *
     * @return string|null
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Set url.
     *
     * @param string|null $url
     *
     * @return Archivo
     */
    public function setUrl($url = null)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url.
     *
     * @return string|null
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set createdAt.
     *
     * @param \DateTime|null $createdAt
     *
     * @return Archivo
     */
    public function setCreatedAt($createdAt = null)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt.
     *
     * @return \DateTime|null
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt.
     *
     * @param \DateTime|null $updatedAt
     *
     * @return Archivo
     */
    public function setUpdatedAt($updatedAt = null)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt.
     *
     * @return \DateTime|null
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set idArchivoCategoria.
     *
     * @param \Catastro\Entity\ArchivoCategoria|null $idArchivoCategoria
     *
     * @return Archivo
     */
    public function setIdArchivoCategoria(\Catastro\Entity\ArchivoCategoria $idArchivoCategoria = null)
    {
        $this->idArchivoCategoria = $idArchivoCategoria;

        return $this;
    }

    /**
     * Get idArchivoCategoria.
     *
     * @return \Catastro\Entity\ArchivoCategoria|null
     */
    public function getIdArchivoCategoria()
    {
        return $this->idArchivoCategoria;
    }
}
