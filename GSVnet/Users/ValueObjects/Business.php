<?php namespace GSVnet\Users\ValueObjects;

use GSVnet\Core\ValueObject;

class Business {

    private $company;
    private $profession;
    private $url;

    function __construct($company, $profession, $url)
    {
        $this->company = ucfirst(trim($company));
        $this->profession = trim($profession);
        $this->url = trim($url);
    }

    public function getCompany()
    {
        return $this->company;
    }

    public function getProfession()
    {
        return $this->profession;
    }

    public function getUrl()
    {
        return $this->url;
    }
}