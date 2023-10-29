<?php namespace GSVnet\Users\ValueObjects;

use GSVnet\Core\ValueObject;

class PhoneNumber {

    protected $phone;

    public function __construct($phone)
    {
        $this->phone = $this->sanitize($phone);
    }

    public function getPhone()
    {
        return $this->phone;
    }

    private function sanitize($phone)
    {
        return trim($phone);
    }
}