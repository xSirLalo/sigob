<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Doctrinemigrationversions
 *
 * @ORM\Table(name="doctrinemigrationversions")
 * @ORM\Entity
 */
class Doctrinemigrationversions
{
    /**
     * @var string
     *
     * @ORM\Column(name="version", type="string", length=1024, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $version;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="executedAt", type="datetime", nullable=true)
     */
    private $executedat;

    /**
     * @var int|null
     *
     * @ORM\Column(name="executionTime", type="integer", nullable=true)
     */
    private $executiontime;



    /**
     * Get version.
     *
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Set executedat.
     *
     * @param \DateTime|null $executedat
     *
     * @return Doctrinemigrationversions
     */
    public function setExecutedat($executedat = null)
    {
        $this->executedat = $executedat;

        return $this;
    }

    /**
     * Get executedat.
     *
     * @return \DateTime|null
     */
    public function getExecutedat()
    {
        return $this->executedat;
    }

    /**
     * Set executiontime.
     *
     * @param int|null $executiontime
     *
     * @return Doctrinemigrationversions
     */
    public function setExecutiontime($executiontime = null)
    {
        $this->executiontime = $executiontime;

        return $this;
    }

    /**
     * Get executiontime.
     *
     * @return int|null
     */
    public function getExecutiontime()
    {
        return $this->executiontime;
    }
}
