<?php

namespace App\Models;

use App\Util\QApiHandler;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Book extends Model
{   
    protected $attributes;

    public function __construct(array $attributes = [])
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
        $book = new Book($handler->getBook($value));
        return $book;
    }

    /**
     * Save a new model and return the instance.
     *
     * @param  array  $attributes
     * @return \Illuminate\Database\Eloquent\Model|$this
     */
    public static function create(array $attributes = [])
    {
        $handler = new QApiHandler(Auth::user());
        
        $book = [
            'title' => $attributes['title'],
            'author' => [
                'id' => intval($attributes['author'])
            ],
            'release_date' => $attributes['release_date'],
            'description' => $attributes['description'],
            'isbn' => $attributes['isbn'],
            'format' => $attributes['format'],
            'number_of_pages' => intval($attributes['number_of_pages'])
        ];

        $book = new Book($handler->createBook($book));

        return $book;
    }

    /**
     * Delete records from the database.
     *
     * @return mixed
     */
    public function delete()
    {
        $handler = new QApiHandler(Auth::user());

        return $handler->deleteBook($this->id);
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
        $books = collect();
        foreach($handler->getBooks()['items'] as $item) {
            //filter incoming data
            $selected_fields = collect($item)->only($columns)->toArray();
            if($columns === ['*']) $books->push(new Book($item));
            else $books->push(new Book($selected_fields));
        }
        return $books;
    }
}