<?php namespace GSVnet\Users\ValueObjects;

use GSVnet\Core\Enums\GenderEnum;

class Gender {

    private GenderEnum $gender;

    function __construct(GenderEnum|string|int|null $gender)
    {
        if (is_string($gender) || is_int($gender))
            $gender = GenderEnum::from((int) $gender);

        $this->gender = $gender;
    }

    public function getGender()
    {
        return $this->gender;
    }
}