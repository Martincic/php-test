<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{   
    protected $attributes;

    public function __construct(array $attributes)
    {
        $this->attributes = $attributes;

        if(!empty($attributes['author'])) $this->attributes['author'] = new Author($attributes['author']);
    }
}