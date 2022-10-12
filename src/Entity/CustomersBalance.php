<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: CustomersBalanceRepository::class)]
class CustomersBalance
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

    #[ORM\GeneratedValue(strategy:"NONE")]
    #[ORM\ManyToOne(targetEntity:"CustomersPayments")]
    #[ORM\JoinColumn(name:"customers_payments_id", referencedColumnName:"id")]
    private ?CustomersPayments $customersPayments;

    #[ORM\Column(type: Types::DECIMAL, precision: 20, scale: '2', nullable: true)]
    private ?string $balance;

    #[ORM\Column(type: Types::DECIMAL, precision: 20, scale: '2', nullable: true)]
    private ?string $lastPaidValue;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $lastPaymentDate;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBalance(): ?string
    {
        return $this->balance;
    }

    public function setBalance(?string $balance): self
    {
        $this->balance = $balance;

        return $this;
    }

    public function getLastPaidValue(): ?string
    {
        return $this->lastPaidValue;
    }

    public function setLastPaidValue(?string $lastPaidValue): self
    {
        $this->lastPaidValue = $lastPaidValue;

        return $this;
    }

    public function getLastPaymentDate(): ?\DateTimeInterface
    {
        return $this->lastPaymentDate;
    }

    public function setLastPaymentDate(?\DateTimeInterface $lastPaymentDate): self
    {
        $this->lastPaymentDate = $lastPaymentDate;

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

    public function getCustomersPayments(): ?CustomersPayments
    {
        return $this->customersPayments;
    }

    public function setCustomersPayments(?CustomersPayments $customersPayments): self
    {
        $this->customersPayments = $customersPayments;

        return $this;
    }


}


