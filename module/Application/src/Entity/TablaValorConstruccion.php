<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TablaValorConstruccion
 *
 * @ORM\Table(name="tabla_valor_construccion")
 * @ORM\Entity
 */
class TablaValorConstruccion
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_tabla_valor_construccion", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idTablaValorConstruccion;

    /**
     * @var string|null
     *
     * @ORM\Column(name="abreviacion", type="string", length=255, nullable=true)
     */
    private $abreviacion;

    /**
     * @var string|null
     *
     * @ORM\Column(name="grupo", type="string", length=255, nullable=true)
     */
    private $grupo;

    /**
     * @var string|null
     *
     * @ORM\Column(name="caracteristicas", type="string", length=255, nullable=true)
     */
    private $caracteristicas;

    /**
     * @var float|null
     *
     * @ORM\Column(name="costo", type="float", precision=10, scale=0, nullable=true)
     */
    private $costo;


}
