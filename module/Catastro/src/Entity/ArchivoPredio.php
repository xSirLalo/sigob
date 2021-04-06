<?php

namespace Catastro\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ArchivoPredio
 *
 * @ORM\Table(name="archivo_predio", uniqueConstraints={@ORM\UniqueConstraint(name="unico", columns={"id_archivo", "id_predio"})}, indexes={@ORM\Index(name="id_predio", columns={"id_predio"}), @ORM\Index(name="IDX_7F23DFFAEBB41DF2", columns={"id_archivo"})})
 * @ORM\Entity
 */
class ArchivoPredio
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
     * @var int|null
     *
     * @ORM\Column(name="estatus", type="integer", nullable=true, options={"default"="1"})
     */
    private $estatus = 1;

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
     * @var \Catastro\Entity\Predio
     *
     * @ORM\ManyToOne(targetEntity="Catastro\Entity\Predio")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_predio", referencedColumnName="id_predio")
     * })
     */
    private $idPredio;



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
     * Set estatus.
     *
     * @param int|null $estatus
     *
     * @return ArchivoPredio
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
     * Set idArchivo.
     *
     * @param \Catastro\Entity\Archivo|null $idArchivo
     *
     * @return ArchivoPredio
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
     * Set idPredio.
     *
     * @param \Catastro\Entity\Predio|null $idPredio
     *
     * @return ArchivoPredio
     */
    public function setIdPredio(\Catastro\Entity\Predio $idPredio = null)
    {
        $this->idPredio = $idPredio;

        return $this;
    }

    /**
     * Get idPredio.
     *
     * @return \Catastro\Entity\Predio|null
     */
    public function getIdPredio()
    {
        return $this->idPredio;
    }
}
