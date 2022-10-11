<?php

namespace App\Entity;


use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: ContractServicesRepository::class)]
class ContractServices
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy:"IDENTITY")]
    #[ORM\SecuenceGenerator(sequenceName:"contract_services_id_seq", allocationSize:1, initialValue:1)]
    #[ORM\Column(name:"id", type:"integer", nullable:false)]
    private ?int $id;
    
    #[ORM\GeneratedValue(strategy:"NONE")]
    #[ORM\ManyToOne(targetEntity:"Services")]
    #[ORM\JoinColumn(name:"services_id", referencedColumnName:"id")]
    private $services;

    
    #[ORM\GeneratedValue(strategy:"NONE")]
    #[ORM\ManyToOne(targetEntity:"Contracts")]
    #[ORM\JoinColumn(name:"contracts_id", referencedColumnName:"id")]
    private  $contracts;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $createdDate;

    public function getCreatedDate(): ?\DateTimeInterface
    {
        return $this->createdDate;
    }

    public function setCreatedDate(?\DateTimeInterface $createdDate): self
    {
        $this->createdDate = $createdDate;

        return $this;
    }

    public function getServices(): ?Services
    {
        return $this->services;
    }

    public function setServices(?Services $services): self
    {
        $this->services = $services;

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

    public function getId(): ?int
    {
        return $this->id;
    }
}