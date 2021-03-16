<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Aportacion
 *
 * @ORM\Table(name="aportacion", indexes={@ORM\Index(name="id_predio", columns={"id_predio"}), @ORM\Index(name="id_contribuyente", columns={"id_contribuyente"})})
 * @ORM\Entity
 */
class Aportacion
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_aportacion", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idAportacion;

    /**
     * @var float|null
     *
     * @ORM\Column(name="pago", type="float", precision=10, scale=0, nullable=true)
     */
    private $pago;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="fecha", type="date", nullable=true)
     */
    private $fecha;

    /**
     * @var float|null
     *
     * @ORM\Column(name="metros_terreno", type="float", precision=10, scale=0, nullable=true)
     */
    private $metrosTerreno;

    /**
     * @var float|null
     *
     * @ORM\Column(name="metros_construccion", type="float", precision=10, scale=0, nullable=true)
     */
    private $metrosConstruccion;

    /**
     * @var float|null
     *
     * @ORM\Column(name="valor_terreno", type="float", precision=10, scale=0, nullable=true)
     */
    private $valorTerreno;

    /**
     * @var float|null
     *
     * @ORM\Column(name="valor_construccion", type="float", precision=10, scale=0, nullable=true)
     */
    private $valorConstruccion;

    /**
     * @var float|null
     *
     * @ORM\Column(name="avaluo", type="float", precision=10, scale=0, nullable=true)
     */
    private $avaluo;

    /**
     * @var int|null
     *
     * @ORM\Column(name="estatus", type="integer", nullable=true)
     */
    private $estatus;

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
     * @var \Application\Entity\Contribuyente
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\Contribuyente")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_contribuyente", referencedColumnName="id_contribuyente")
     * })
     */
    private $idContribuyente;

    /**
     * @var \Application\Entity\Predio
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\Predio")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_predio", referencedColumnName="id_predio")
     * })
     */
    private $idPredio;


}
