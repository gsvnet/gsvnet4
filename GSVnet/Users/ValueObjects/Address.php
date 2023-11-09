<?php namespace GSVnet\Users\ValueObjects;

use GSVnet\Core\ValueObject;

class Address {

    protected $street;
    protected $zipCode;
    protected $town;
    protected $country;

    public function __construct($street, $zipCode, $town, $country = 'Nederland')
    {
        $this->street = ucfirst(trim($street));
        $this->zipCode = strtoupper(trim($zipCode));
        $this->town = ucfirst(trim($town));
        $this->country = ucfirst(trim($country));
    }

    public function equals(Address $other)
    {
        return $this->street === $other->street
            && $this->country === $other->country
            && $this->town === $other->town
            && $this->zipCode === $other->zipCode;
    }

    public function getStreet()
    {
        return $this->street;
    }

    public function getZipCode()
    {
        return $this->zipCode;
    }

    public function getTown()
    {
        return $this->town;
    }

    public function getCountry()
    {
        return $this->country;
    }
}
