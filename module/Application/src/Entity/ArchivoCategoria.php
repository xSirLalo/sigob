<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ArchivoCategoria
 *
 * @ORM\Table(name="archivo_categoria")
 * @ORM\Entity
 */
class ArchivoCategoria
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_archivo_categoria", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idArchivoCategoria;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nombre", type="string", length=255, nullable=true)
     */
    private $nombre;

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


}
