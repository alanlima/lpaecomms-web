<?php

namespace App\Utils;

class Security 
{
    public function EncryptPassword(string $password) {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public function IsEquals(string $password, string $encryptedPassword) {
        return password_verify($password, $encryptedPassword);
    }
}