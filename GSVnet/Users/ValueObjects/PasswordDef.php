<?php namespace GSVnet\Users\ValueObjects;

use GSVnet\Core\ValueObject;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordDef extends ValueObject {

    private $password;

    public function __construct($password)
    {
        $this->password = $password;

        $this->validate([
            'password' => ['required', Password::defaults()]
        ]);
    }

    public function getEncryptedPassword()
    {
        return Hash::make($this->password);
    }
}