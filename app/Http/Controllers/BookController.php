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
        $handler = new QApiHandler(Auth::user());
        $books = collect();
        foreach($handler->getBooks()['items'] as $item) {
            $books->push(new Book($item));
        }

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
        $handler = new QApiHandler(Auth::user());
        $authors = collect();
        foreach($handler->getAuthors()['items'] as $item) {
            $authors->push(new Author($item));
        }

        return view('books.add')->with('authors', $authors);
    }
    
    public function store(HttpRequest $request)
    {
        $book = Book::create($request->all());
        return view('books.single')->with('book', $book);
    }
}
