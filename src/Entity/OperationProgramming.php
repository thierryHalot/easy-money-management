<?php

namespace App\Entity;

use App\Repository\OperationProgrammingRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OperationProgrammingRepository::class)
 */
class OperationProgramming
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $startDate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $endDate;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $frequence;

    /**
     * @ORM\OneToOne(targetEntity=Operation::class, mappedBy="programming", cascade={"persist", "remove"})
     */
    private $operation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(?\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getFrequence(): ?string
    {
        return $this->frequence;
    }

    public function setFrequence(string $frequence): self
    {
        $this->frequence = $frequence;

        return $this;
    }

    public function getOperation(): ?Operation
    {
        return $this->operation;
    }

    public function setOperation(?Operation $operation): self
    {
        // unset the owning side of the relation if necessary
        if ($operation === null && $this->operation !== null) {
            $this->operation->setProgramming(null);
        }

        // set the owning side of the relation if necessary
        if ($operation !== null && $operation->getProgramming() !== $this) {
            $operation->setProgramming($this);
        }

        $this->operation = $operation;

        return $this;
    }
}
