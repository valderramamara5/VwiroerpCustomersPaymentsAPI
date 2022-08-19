<?php
namespace App\DTO;

class DataEnquire
{
    private  $comercialName=null;
    private ?array $mainContact=null;
    private ?string $email=null;
    private ?int $customerType=null;
    private ?array $identification=null;
    private ?array $phoneNumbers=null;
    private ?array $address=null;
    private ?array $references=null;
    private ?string $firstName=null;
    private ?string $middleName=null;
    private ?string $lastName=null;
    private ?string $secondLastName=null;

    /**
     * Get the value of comercialName
     */ 
    public function getComercialName()
    {
        return $this->comercialName;
    }

    /**
     * Set the value of comercialName
     *
     * @return  self
     */ 
    public function setComercialName($comercialName)
    {
        $this->comercialName = $comercialName;

        return $this;
    }

   /**
    * Get the value of mainContact
    */ 
   public function getMainContact()
   {
      return $this->mainContact;
   }

   /**
    * Set the value of mainContact
    *
    * @return  self
    */ 
   public function setMainContact($mainContact)
   {
      $this->mainContact = $mainContact;

      return $this;
   }

    /**
     * Get the value of customerType
     */ 
    public function getCustomerType()
    {
        return $this->customerType;
    }

    /**
     * Set the value of customerType
     *
     * @return  self
     */ 
    public function setCustomerType($customerType)
    {
        $this->customerType = $customerType;

        return $this;
    }

    /**
     * Get the value of identification
     */ 
    public function getIdentification()
    {
        return $this->identification;
    }

    /**
     * Set the value of identification
     *
     * @return  self
     */ 
    public function setIdentification($identification)
    {
        $this->identification = $identification;

        return $this;
    }

    /**
     * Get the value of phoneNumbers
     */ 
    public function getPhoneNumbers()
    {
        return $this->phoneNumbers;
    }

    /**
     * Set the value of phoneNumbers
     *
     * @return  self
     */ 
    public function setPhoneNumbers($phoneNumbers)
    {
        $this->phoneNumbers = $phoneNumbers;

        return $this;
    }

    /**
     * Get the value of address
     */ 
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set the value of address
     *
     * @return  self
     */ 
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    

   /**
    * Get the value of references
    */ 
   public function getReferences()
   {
      return $this->references;
   }

   /**
    * Set the value of references
    *
    * @return  self
    */ 
   public function setReferences($references)
   {
      $this->references = $references;

      return $this;
   }

    /**
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of firstName
     */ 
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set the value of firstName
     *
     * @return  self
     */ 
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get the value of middleName
     */ 
    public function getMiddleName()
    {
        return $this->middleName;
    }

    /**
     * Set the value of middleName
     *
     * @return  self
     */ 
    public function setMiddleName($middleName)
    {
        $this->middleName = $middleName;

        return $this;
    }

    /**
     * Get the value of lastName
     */ 
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set the value of lastName
     *
     * @return  self
     */ 
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get the value of secondLastName
     */ 
    public function getSecondLastName()
    {
        return $this->secondLastName;
    }

    /**
     * Set the value of secondLastName
     *
     * @return  self
     */ 
    public function setSecondLastName($secondLastName)
    {
        $this->secondLastName = $secondLastName;

        return $this;
    }
}


