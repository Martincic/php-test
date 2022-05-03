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

    public function single(Author $author)
    {
        return view('authors.single')->with('author', $author);
    }
    
    public function delete(Author $author)
    {
        $handler = new QApiHandler(Auth::user());

        if($author->books->isEmpty()) {
            $handler->deleteAuthor($author->id);
            return redirect('authors')->with('author_deleted', $author);
        }

        return view('authors.single')->with('author', $author);
    }
}

