<?php

namespace Madco\Tecsafe\Tecsafe\Api\Generated\Model;

class CustomerLoginRequest extends \ArrayObject
{
    /**
     * @var array
     */
    protected $initialized = [];
    public function isInitialized($property): bool
    {
        return array_key_exists($property, $this->initialized);
    }
    /**
     * Secret to authenticate, JWT or Static Token
     *
     * @var string
     */
    protected $secret;
    /**
     * Customer email, please make sure to include a notice in your privacy policy
     *
     * @var string
     */
    protected $email;
    /**
     * Customer first name, please make sure to include a notice in your privacy policy
     *
     * @var string
     */
    protected $firstName;
    /**
     * Customer last name, please make sure to include a notice in your privacy policy
     *
     * @var string
     */
    protected $lastName;
    /**
     * Customer company, please make sure to include a notice in your privacy policy
     *
     * @var string
     */
    protected $company;
    /**
     * Customer identifier
     *
     * @var string
     */
    protected $identifier;
    /**
     * Is the customer a guest?
     *
     * @var bool
     */
    protected $isGuest;
    /**
     * Human readable external group name
     *
     * @var string
     */
    protected $groupIdentifier;
    /**
     * ISO 4217 currency code
     *
     * @var string
     */
    protected $currency;
    /**
     * Secret to authenticate, JWT or Static Token
     *
     * @return string
     */
    public function getSecret(): string
    {
        return $this->secret;
    }
    /**
     * Secret to authenticate, JWT or Static Token
     *
     * @param string $secret
     *
     * @return self
     */
    public function setSecret(string $secret): self
    {
        $this->initialized['secret'] = true;
        $this->secret = $secret;
        return $this;
    }
    /**
     * Customer email, please make sure to include a notice in your privacy policy
     *
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }
    /**
     * Customer email, please make sure to include a notice in your privacy policy
     *
     * @param string $email
     *
     * @return self
     */
    public function setEmail(string $email): self
    {
        $this->initialized['email'] = true;
        $this->email = $email;
        return $this;
    }
    /**
     * Customer first name, please make sure to include a notice in your privacy policy
     *
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }
    /**
     * Customer first name, please make sure to include a notice in your privacy policy
     *
     * @param string $firstName
     *
     * @return self
     */
    public function setFirstName(string $firstName): self
    {
        $this->initialized['firstName'] = true;
        $this->firstName = $firstName;
        return $this;
    }
    /**
     * Customer last name, please make sure to include a notice in your privacy policy
     *
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }
    /**
     * Customer last name, please make sure to include a notice in your privacy policy
     *
     * @param string $lastName
     *
     * @return self
     */
    public function setLastName(string $lastName): self
    {
        $this->initialized['lastName'] = true;
        $this->lastName = $lastName;
        return $this;
    }
    /**
     * Customer company, please make sure to include a notice in your privacy policy
     *
     * @return string
     */
    public function getCompany(): string
    {
        return $this->company;
    }
    /**
     * Customer company, please make sure to include a notice in your privacy policy
     *
     * @param string $company
     *
     * @return self
     */
    public function setCompany(string $company): self
    {
        $this->initialized['company'] = true;
        $this->company = $company;
        return $this;
    }
    /**
     * Customer identifier
     *
     * @return string
     */
    public function getIdentifier(): string
    {
        return $this->identifier;
    }
    /**
     * Customer identifier
     *
     * @param string $identifier
     *
     * @return self
     */
    public function setIdentifier(string $identifier): self
    {
        $this->initialized['identifier'] = true;
        $this->identifier = $identifier;
        return $this;
    }
    /**
     * Is the customer a guest?
     *
     * @return bool
     */
    public function getIsGuest(): bool
    {
        return $this->isGuest;
    }
    /**
     * Is the customer a guest?
     *
     * @param bool $isGuest
     *
     * @return self
     */
    public function setIsGuest(bool $isGuest): self
    {
        $this->initialized['isGuest'] = true;
        $this->isGuest = $isGuest;
        return $this;
    }
    /**
     * Human readable external group name
     *
     * @return string
     */
    public function getGroupIdentifier(): string
    {
        return $this->groupIdentifier;
    }
    /**
     * Human readable external group name
     *
     * @param string $groupIdentifier
     *
     * @return self
     */
    public function setGroupIdentifier(string $groupIdentifier): self
    {
        $this->initialized['groupIdentifier'] = true;
        $this->groupIdentifier = $groupIdentifier;
        return $this;
    }
    /**
     * ISO 4217 currency code
     *
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }
    /**
     * ISO 4217 currency code
     *
     * @param string $currency
     *
     * @return self
     */
    public function setCurrency(string $currency): self
    {
        $this->initialized['currency'] = true;
        $this->currency = $currency;
        return $this;
    }
}