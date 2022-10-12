<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;

#[ORM\Entity(repositoryClass: CustomersPaymentsRepository::class)]
class CustomersPayments
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy:"IDENTITY")]
    #[ORM\SecuenceGenerator(sequenceName:"contracts_id_seq", allocationSize:1, initialValue:1)]
    #[ORM\Column(name:"id", type:"integer", nullable:false)]
    private ?int $id;

    #[ORM\GeneratedValue(strategy:"NONE")]
    #[ORM\ManyToOne(targetEntity:"Customers")]
    #[ORM\JoinColumn(name:"customers_id", referencedColumnName:"id")]
    #[ORM\JoinColumn(name:"customers_customer_types_id", referencedColumnName:"customer_types_id")]
    #[ORM\JoinColumn(name:"customers_identifier_types_id", referencedColumnName:"identifier_types_id")]
    private ?Customers $customers;

    #[ORM\GeneratedValue(strategy:"NONE")]
    #[ORM\ManyToOne(targetEntity:"Contracts")]
    #[ORM\JoinColumn(name:"contracts_id", referencedColumnName:"id")]
    private ?Contracts $contracts;

    #[ORM\Column(type: Types::DECIMAL, precision: 20, scale: '2', nullable: true)]
    private ?string $paidValue;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $note = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $paymentDate;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPaidValue(): ?string
    {
        return $this->paidValue;
    }

    public function setPaidValue(?string $paidValue): self
    {
        $this->paidValue = $paidValue;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): self
    {
        $this->note = $note;

        return $this; 
    }

    public function getPaymentDate(): ?\DateTimeInterface
    {
        return $this->paymentDate;
    }

    public function setPaymentDate(?\DateTimeInterface $paymentDate): self
    {
        $this->paymentDate = $paymentDate;

        return $this;
    }

    public function getCustomers(): ?Customers
    {
        return $this->customers;
    }

    public function setCustomers(?Customers $customers): self
    {
        $this->customers = $customers;

        return $this;
    }

    public function getContracts(): ?Contracts
    {
        return $this->contracts;
    }

    public function setContracts(?Contracts $contracts): self
    {
        $this->contracts = $contracts;

        return $this;
    }
}