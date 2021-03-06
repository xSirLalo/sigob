<?php

namespace Catastro\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ArchivoContribuyente
 *
 * @ORM\Table(name="archivo_contribuyente", uniqueConstraints={@ORM\UniqueConstraint(name="id_archivo", columns={"id_archivo", "id_contribuyente"})}, indexes={@ORM\Index(name="id_contribuyente", columns={"id_contribuyente"}), @ORM\Index(name="IDX_F7068FB2EBB41DF2", columns={"id_archivo"})})
 * @ORM\Entity
 */
class ArchivoContribuyente
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_archivo_predio", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idArchivoPredio;

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
     * @var \Catastro\Entity\Archivo
     *
     * @ORM\ManyToOne(targetEntity="Catastro\Entity\Archivo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_archivo", referencedColumnName="id_archivo")
     * })
     */
    private $idArchivo;

    /**
     * @var \Catastro\Entity\Contribuyente
     *
     * @ORM\ManyToOne(targetEntity="Catastro\Entity\Contribuyente")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_contribuyente", referencedColumnName="id_contribuyente")
     * })
     */
    private $idContribuyente;



    /**
     * Get idArchivoPredio.
     *
     * @return int
     */
    public function getIdArchivoPredio()
    {
        return $this->idArchivoPredio;
    }

    /**
     * Set estatus.
     *
     * @param int|null $estatus
     *
     * @return ArchivoContribuyente
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
     * @return ArchivoContribuyente
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
     * @return ArchivoContribuyente
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
     * Set idArchivo.
     *
     * @param \Catastro\Entity\Archivo|null $idArchivo
     *
     * @return ArchivoContribuyente
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

    /**
     * Set idContribuyente.
     *
     * @param \Catastro\Entity\Contribuyente|null $idContribuyente
     *
     * @return ArchivoContribuyente
     */
    public function setIdContribuyente(\Catastro\Entity\Contribuyente $idContribuyente = null)
    {
        $this->idContribuyente = $idContribuyente;

        return $this;
    }

    /**
     * Get idContribuyente.
     *
     * @return \Catastro\Entity\Contribuyente|null
     */
    public function getIdContribuyente()
    {
        return $this->idContribuyente;
    }
}
