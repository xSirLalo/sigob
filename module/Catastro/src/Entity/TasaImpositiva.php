<?php

namespace Catastro\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TasaImpositiva
 *
 * @ORM\Table(name="tasa_impositiva")
 * @ORM\Entity
 */
class TasaImpositiva
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_tasa_impositiva", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idTasaImpositiva;

    /**
     * @var string|null
     *
     * @ORM\Column(name="predios_urbanos_edificados", type="string", length=255, nullable=true)
     */
    private $prediosUrbanosEdificados;

    /**
     * @var float|null
     *
     * @ORM\Column(name="costo", type="float", precision=10, scale=0, nullable=true)
     */
    private $costo;



    /**
     * Get idTasaImpositiva.
     *
     * @return int
     */
    public function getIdTasaImpositiva()
    {
        return $this->idTasaImpositiva;
    }

    /**
     * Set prediosUrbanosEdificados.
     *
     * @param string|null $prediosUrbanosEdificados
     *
     * @return TasaImpositiva
     */
    public function setPrediosUrbanosEdificados($prediosUrbanosEdificados = null)
    {
        $this->prediosUrbanosEdificados = $prediosUrbanosEdificados;

        return $this;
    }

    /**
     * Get prediosUrbanosEdificados.
     *
     * @return string|null
     */
    public function getPrediosUrbanosEdificados()
    {
        return $this->prediosUrbanosEdificados;
    }

    /**
     * Set costo.
     *
     * @param float|null $costo
     *
     * @return TasaImpositiva
     */
    public function setCosto($costo = null)
    {
        $this->costo = $costo;

        return $this;
    }

    /**
     * Get costo.
     *
     * @return float|null
     */
    public function getCosto()
    {
        return $this->costo;
    }
}
