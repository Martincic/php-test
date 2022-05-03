<?php

namespace App\Models;

use App\Util\QApiHandler;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Author extends Model
{   
    protected $attributes;

    public function __construct(array $attributes = [])
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

    /**
     * Retrieve the model for a bound value.
     *
     * @param  mixed  $value
     * @param  string|null  $field
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function resolveRouteBinding($value, $field = null)
    {
        $handler = new QApiHandler(Auth::user());
        $author = new Author($handler->getAuthor($value));
        return $author;
    }
    
    /**
     * Delete records from the database.
     *
     * @return mixed
     */
    public function delete()
    {
        $handler = new QApiHandler(Auth::user());

        return $handler->deleteAuthor($this->id);
    }

    /**
     * Get the hydrated models without eager loading.
     *
     * @param  array|string  $columns
     * @return \Illuminate\Database\Eloquent\Model[]|static[]
     */
    public static function getModels($columns = ['*'])
    {
        $handler = new QApiHandler(Auth::user());
        $authors = collect();
        foreach($handler->getAuthors()['items'] as $item) {
            //filter incoming data
            $selected_fields = collect($item)->only($columns)->toArray();
            if($columns === ['*']) $authors->push(new Author($item));
            else $authors->push(new Author($selected_fields));
        }
        return $authors;
    }
}