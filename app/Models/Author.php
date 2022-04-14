<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{   
    protected $attributes;

    public function __construct(array $attributes)
    {
        $this->attributes = $attributes;

        $books = collect();
        // If there are books, convert them to objects, otherwise assign empty collection
        if(!empty($attributes['books'])) {
            foreach($attributes['books'] as $book) {
                $books->push(new Book($book));
            }
        }
        $this->books = $books;
    }

    protected function getNameAttribute()
    {
        return $this->first_name.' '.$this->last_name;
    }
    
    protected function getBirthDateAttribute()
    {
        return Carbon::parse($this->birthday)->format('Y-m-d');
    }
}