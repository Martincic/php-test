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
        $authors = Author::getModels();

        return view('authors.index')->with('authors', $authors);
    }

    public function single(Author $author)
    {
        return view('authors.single')->with('author', $author);
    }
    
    public function delete(Author $author)
    {
        $author->delete();

        return redirect('authors')->with('author_deleted', $author);
    }
}

