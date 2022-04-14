<?php

namespace App\Models;

use Illuminate\Auth\GenericUser;

class ApiUser extends GenericUser
{
    public function __construct(array $attributes)
    {
        $this->attributes = $attributes ?? null;

        //convert array attributes to object
        $this->attributes['user'] = new User($attributes['user']);
    }

    public function getRememberTokenName()
    {
        return 'token_key';
    }
}
