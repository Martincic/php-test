<?php

namespace App\Models;

use Illuminate\Auth\GenericUser;

class ApiUser extends GenericUser
{
    public function __construct(array $attributes)
    {
        $this->attributes = $attributes;

        //convert array attribute to object attribute
        $this->attributes['user'] = new User($attributes['user']);
    }

    public function getRememberTokenName()
    {
        return 'token_key';
    }
}
