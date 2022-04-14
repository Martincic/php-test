<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Util\QApiHandler;
use Illuminate\Support\Facades\Auth;

class AuthorController extends Controller
{
    public function index()
    {
        $handler = new QApiHandler(Auth::user());
        $authors = collect();
        foreach($handler->getAuthors()['items'] as $item) {
            $authors->push(new Author($item));
        }

        return view('authors.index')->with('authors', $authors);
    }

    public function single(string $author_id)
    {
        $handler = new QApiHandler(Auth::user());
        $author = new Author($handler->getAuthor($author_id));

        return view('authors.single')->with('author', $author);
    }
}

