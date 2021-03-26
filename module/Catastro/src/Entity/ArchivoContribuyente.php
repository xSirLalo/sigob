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
     * @ORM\Column(name="id_archivo_contribuyente", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idArchivoContribuyente;

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
     * Get idArchivoContribuyente.
     *
     * @return int
     */
    public function getIdArchivoContribuyente()
    {
        return $this->idArchivoContribuyente;
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
