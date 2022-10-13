<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;

#[ORM\Entity(repositoryClass: CustomersPaymentsRepository::class)]
class CustomersPayments
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy:"IDENTITY")]
    #[ORM\SecuenceGenerator(sequenceName:"customers_payments_id_seq", allocationSize:1, initialValue:1)]
    #[ORM\Column(name:"id", type:"integer", nullable:false)]
    private ?int $id;

    #[ORM\Column(type:"integer", nullable:false)]
    private ?int $contractsId;

    #[ORM\Column(type:"integer", nullable:false)]
    private ?int $userSystem;

    #[ORM\Column(type: Types::DECIMAL, precision: 20, scale: '2', nullable: true)]
    private ?string $paidValue;

    #[ORM\Column(length: 128, nullable: true)]
    private ?string $methodPayment = null;

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

    public function getContractsId(): ?int
    {
        return $this->contractsId;
    }

    public function setContractsId(int $contractsId): self
    {
        $this->contractsId = $contractsId;

        return $this;
    }

    public function getMethodPayment(): ?string
    {
        return $this->methodPayment;
    }

    public function setMethodPayment(?string $methodPayment): self
    {
        $this->methodPayment = $methodPayment;

        return $this;
    }

    public function getUserSystem(): ?int
    {
        return $this->userSystem;
    }

    public function setUserSystem(int $userSystem): self
    {
        $this->userSystem = $userSystem;

        return $this;
    }
}