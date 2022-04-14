<?php

namespace App\Models;

use App\Util\QApiHandler;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Book extends Model
{   
    protected $attributes;

    public function __construct(array $attributes)
    {
        $this->attributes = $attributes;

        // If author is set, define it
        if (!empty($attributes['author'])) {
            $handler = new QApiHandler(Auth::user());
            $id = $attributes['author']['id'];
            $this->attributes['author'] = new Author($handler->getAuthor($id));
        }
    }

    protected function getReleaseAttribute()
    {
        return Carbon::parse($this->release_date)->format('Y-m-d');
    }
}