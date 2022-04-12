<?php

namespace App\Entity;

use App\Repository\OperationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OperationRepository::class)
 */
class Operation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @ORM\Column(type="float")
     */
    private $amount;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $operationDate;

    /**
     * @ORM\ManyToOne(targetEntity=BankAccount::class, inversedBy="operations")
     */
    private $bankAccount;

    /**
     * @ORM\ManyToOne(targetEntity=OperationCategory::class, inversedBy="operations")
     */
    private $category;

    /**
     * @ORM\OneToOne(targetEntity=OperationProgramming::class, inversedBy="operation", cascade={"persist", "remove"})
     */
    private $programming;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getOperationDate(): ?\DateTimeInterface
    {
        return $this->operationDate;
    }

    public function setOperationDate(?\DateTimeInterface $operationDate): self
    {
        $this->operationDate = $operationDate;

        return $this;
    }

    public function getBankAccount(): ?BankAccount
    {
        return $this->bankAccount;
    }

    public function setBankAccount(?BankAccount $bankAccount): self
    {
        $this->bankAccount = $bankAccount;

        return $this;
    }

    public function getCategory(): ?OperationCategory
    {
        return $this->category;
    }

    public function setCategory(?OperationCategory $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getProgramming(): ?OperationProgramming
    {
        return $this->programming;
    }

    public function setProgramming(?OperationProgramming $programming): self
    {
        $this->programming = $programming;

        return $this;
    }
}
