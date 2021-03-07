<?php

namespace Catastro\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Archivo
 *
 * @ORM\Table(name="archivo", indexes={@ORM\Index(name="id_contribuyente", columns={"id_contribuyente"}), @ORM\Index(name="id_archivo_categoria", columns={"id_archivo_categoria"}), @ORM\Index(name="id_predio", columns={"id_predio"})})
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
     * @ORM\Column(name="archivo", type="blob", length=0, nullable=true)
     */
    private $archivo;

    /**
     * @var string|null
     *
     * @ORM\Column(name="estension", type="string", length=45, nullable=true)
     */
    private $estension;

    /**
     * @var string|null
     *
     * @ORM\Column(name="tamanio", type="string", length=45, nullable=true)
     */
    private $tamanio;

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
     * @var \Catastro\Entity\Contribuyente
     *
     * @ORM\ManyToOne(targetEntity="Catastro\Entity\Contribuyente")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_contribuyente", referencedColumnName="id_contribuyente")
     * })
     */
    private $idContribuyente;

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
     * Get idArchivo.
     *
     * @return int
     */
    public function getIdArchivo()
    {
        return $this->idArchivo;
    }

    /**
     * Set archivo.
     *
     * @param string|null $archivo
     *
     * @return Archivo
     */
    public function setArchivo($archivo = null)
    {
        $this->archivo = $archivo;

        return $this;
    }

    /**
     * Get archivo.
     *
     * @return string|null
     */
    public function getArchivo()
    {
        return $this->archivo;
    }

    /**
     * Set estension.
     *
     * @param string|null $estension
     *
     * @return Archivo
     */
    public function setEstension($estension = null)
    {
        $this->estension = $estension;

        return $this;
    }

    /**
     * Get estension.
     *
     * @return string|null
     */
    public function getEstension()
    {
        return $this->estension;
    }

    /**
     * Set tamanio.
     *
     * @param string|null $tamanio
     *
     * @return Archivo
     */
    public function setTamanio($tamanio = null)
    {
        $this->tamanio = $tamanio;

        return $this;
    }

    /**
     * Get tamanio.
     *
     * @return string|null
     */
    public function getTamanio()
    {
        return $this->tamanio;
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

    /**
     * Set idContribuyente.
     *
     * @param \Catastro\Entity\Contribuyente|null $idContribuyente
     *
     * @return Archivo
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

    /**
     * Set idPredio.
     *
     * @param \Catastro\Entity\Predio|null $idPredio
     *
     * @return Archivo
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
