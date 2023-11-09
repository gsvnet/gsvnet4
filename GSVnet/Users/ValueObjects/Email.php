<?php namespace GSVnet\Users\ValueObjects;

class Email {

    private $email;

    public function __construct($email)
    {
        $this->email = $this->sanitize($email);
    }

    public function getEmail()
    {
        return $this->email;
    }

    private function sanitize($email)
    {
        return trim($email);
    }
}