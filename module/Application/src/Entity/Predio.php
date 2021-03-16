<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Predio
 *
 * @ORM\Table(name="predio", indexes={@ORM\Index(name="id_contribuyente", columns={"id_contribuyente"})})
 * @ORM\Entity
 */
class Predio
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_predio", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPredio;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ubicacion", type="string", length=255, nullable=true)
     */
    private $ubicacion;

    /**
     * @var string|null
     *
     * @ORM\Column(name="colonia", type="string", length=255, nullable=true)
     */
    private $colonia;

    /**
     * @var string|null
     *
     * @ORM\Column(name="localidad", type="string", length=255, nullable=true)
     */
    private $localidad;

    /**
     * @var string|null
     *
     * @ORM\Column(name="municipio", type="string", length=255, nullable=true)
     */
    private $municipio;

    /**
     * @var string|null
     *
     * @ORM\Column(name="calle", type="string", length=255, nullable=true)
     */
    private $calle;

    /**
     * @var string|null
     *
     * @ORM\Column(name="clave_catastral", type="string", length=255, nullable=true)
     */
    private $claveCatastral;

    /**
     * @var int|null
     *
     * @ORM\Column(name="cve_predio", type="bigint", nullable=true)
     */
    private $cvePredio;

    /**
     * @var string|null
     *
     * @ORM\Column(name="numero_exterior", type="string", length=255, nullable=true)
     */
    private $numeroExterior;

    /**
     * @var string|null
     *
     * @ORM\Column(name="numero_interior", type="string", length=255, nullable=true)
     */
    private $numeroInterior;

    /**
     * @var string|null
     *
     * @ORM\Column(name="estatus", type="string", length=255, nullable=true)
     */
    private $estatus;

    /**
     * @var string|null
     *
     * @ORM\Column(name="tipo", type="string", length=255, nullable=true)
     */
    private $tipo;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ultimo_ejercicio_pagado", type="string", length=255, nullable=true)
     */
    private $ultimoEjercicioPagado;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ultimo_periodo_pagado", type="string", length=255, nullable=true)
     */
    private $ultimoPeriodoPagado;

    /**
     * @var string|null
     *
     * @ORM\Column(name="titular", type="string", length=255, nullable=true)
     */
    private $titular;

    /**
     * @var string|null
     *
     * @ORM\Column(name="titular_anterior", type="string", length=255, nullable=true)
     */
    private $titularAnterior;

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


}
