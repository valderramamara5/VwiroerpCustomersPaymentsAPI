<?php

namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;

#[ORM\Entity(repositoryClass: CustomersContactRepository::class)]


class CustomersContact
{
    
    //Quien es id? = referencedColumnName:"id CustomerTypes"
    //Falta idCustomerTypesCustomers

    #[ORM\Id]
    #[ORM\GeneratedValue(strategy:"SEQUENCE")]
    #[ORM\SecuenceGenerator(sequenceName:"customers_contact_id_seq", allocationSize:1, initialValue:1)]
    #[ORM\Column(name:"id", type:"integer", nullable:false)]
    private ?int $id;

    #[ORM\GeneratedValue(strategy:"NONE")]
    #[ORM\ManyToOne(targetEntity:"Contacts")]
    #[ORM\JoinColumn(name:"contacts_id", referencedColumnName:"id")]
    #[ORM\JoinColumn(name:"contacts_identifier_types_id", referencedColumnName:"identifier_types_id")]
    private ?Contacts $contacts;

    // #[ORM\GeneratedValue(strategy:"NONE")]
    // #[ORM\ManyToOne(targetEntity:"Contacts")]
    // #[ORM\JoinColumn(name:"contacts_id", referencedColumnName:"id")]
    // private ?Contacts $contacts;

    // #[ORM\GeneratedValue(strategy:"NONE")]
    // #[ORM\ManyToOne(targetEntity:"IdentifierTypes")]
    // #[ORM\JoinColumn(name:"contacts_identifier_types_id", referencedColumnName:"id")]
    // private ?Contacts $contactsIdentifierTypes;

    // #[ORM\GeneratedValue(strategy:"NONE")]
    // #[ORM\ManyToOne(targetEntity:"Customers")]
    // #[ORM\JoinColumn(name:"customers_id", referencedColumnName:"id")]
    // private ?Customers $customers;

    #[ORM\GeneratedValue(strategy:"NONE")]
    #[ORM\ManyToOne(targetEntity:"Customers")]
    #[ORM\JoinColumn(name:"customers_id", referencedColumnName:"id")]
    #[ORM\JoinColumn(name:"customers_customer_types_id", referencedColumnName:"customer_types_id")]
    #[ORM\JoinColumn(name:"customers_identifier_types_id", referencedColumnName:"identifier_types_id")]
    private ?Customers $customers;
   
    // #[ORM\GeneratedValue(strategy:"NONE")]
    // #[ORM\ManyToOne(targetEntity:"CustomerTypes")]
    // #[ORM\JoinColumn(name:"customers_customer_types_id", referencedColumnName:"id")]
    // private ?Customers $customersCustomerTypes;

    // #[ORM\GeneratedValue(strategy:"NONE")]
    // #[ORM\ManyToOne(targetEntity:"IdentifierTypes")]
    // #[ORM\JoinColumn(name:"customers_identifier_types_id", referencedColumnName:"id")]
    // private ?Customers $customersIdentifierTypes;

    public function setPrimaryKeys(Customers $customer, Contacts $contacts){
        $this  ->setCustomers($customer);
       $this -> setContacts($contacts);

   }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContacts(): ?Contacts
    {
        return $this->contacts;
    }

    public function setContacts(?Contacts $contacts): self
    {
        $this->contacts = $contacts;

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
}    