<?php

namespace GSVnet\Users\ValueObjects;

class Username {

    private $username;

    public function __construct($username)
    {
        $this->username = $this->sanitize($username);
    }

    public function getUsername()
    {
        return $this->username;
    }

    private function sanitize($username)
    {
        return trim($username);
    }
}