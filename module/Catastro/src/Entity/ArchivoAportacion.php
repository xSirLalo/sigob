<?php

namespace Catastro\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ArchivoAportacion
 *
 * @ORM\Table(name="archivo_aportacion", indexes={@ORM\Index(name="id_archivo", columns={"id_archivo"}), @ORM\Index(name="id_aportacion", columns={"id_aportacion"})})
 * @ORM\Entity
 */
class ArchivoAportacion
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_archivo_aportacion", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idArchivoAportacion;

    /**
     * @var int|null
     *
     * @ORM\Column(name="estatus", type="integer", nullable=true, options={"default"="1"})
     */
    private $estatus = 1;

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
     * @var \Catastro\Entity\Aportacion
     *
     * @ORM\ManyToOne(targetEntity="Catastro\Entity\Aportacion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_aportacion", referencedColumnName="id_aportacion")
     * })
     */
    private $idAportacion;

    /**
     * @var \Catastro\Entity\Archivo
     *
     * @ORM\ManyToOne(targetEntity="Catastro\Entity\Archivo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_archivo", referencedColumnName="id_archivo")
     * })
     */
    private $idArchivo;



    /**
     * Get idArchivoAportacion.
     *
     * @return int
     */
    public function getIdArchivoAportacion()
    {
        return $this->idArchivoAportacion;
    }

    /**
     * Set estatus.
     *
     * @param int|null $estatus
     *
     * @return ArchivoAportacion
     */
    public function setEstatus($estatus = null)
    {
        $this->estatus = $estatus;

        return $this;
    }

    /**
     * Get estatus.
     *
     * @return int|null
     */
    public function getEstatus()
    {
        return $this->estatus;
    }

    /**
     * Set createdAt.
     *
     * @param \DateTime|null $createdAt
     *
     * @return ArchivoAportacion
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
     * @return ArchivoAportacion
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
     * Set idAportacion.
     *
     * @param \Catastro\Entity\Aportacion|null $idAportacion
     *
     * @return ArchivoAportacion
     */
    public function setIdAportacion(\Catastro\Entity\Aportacion $idAportacion = null)
    {
        $this->idAportacion = $idAportacion;

        return $this;
    }

    /**
     * Get idAportacion.
     *
     * @return \Catastro\Entity\Aportacion|null
     */
    public function getIdAportacion()
    {
        return $this->idAportacion;
    }

    /**
     * Set idArchivo.
     *
     * @param \Catastro\Entity\Archivo|null $idArchivo
     *
     * @return ArchivoAportacion
     */
    public function setIdArchivo(\Catastro\Entity\Archivo $idArchivo = null)
    {
        $this->idArchivo = $idArchivo;

        return $this;
    }

    /**
     * Get idArchivo.
     *
     * @return \Catastro\Entity\Archivo|null
     */
    public function getIdArchivo()
    {
        return $this->idArchivo;
    }
}
