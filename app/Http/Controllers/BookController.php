<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Util\QApiHandler;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::getModels();

        return view('books.index')->with('books', $books);
    }

    public function single(Book $book)
    {
        return view('books.single')->with('book', $book);
    }
    
    public function delete(Book $book)
    {
        $book->delete();
        
        return redirect('books')->with('book_deleted', $book);
    }
    
    public function create()
    {
        $authors = Author::getModels();

        return view('books.add')->with('authors', $authors);
    }
    
    public function store(HttpRequest $request)
    {
        $book = Book::create($request->all());

        return view('books.single')->with('book', $book);
    }
}