<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Util\QApiHandler;
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

    public function single(string $book_id)
    {
        $handler = new QApiHandler(Auth::user());
        $book = new Book($handler->getBook($book_id));
        return view('books.single')->with('book', $book);
    }
    
    public function delete(string $book_id)
    {
        $handler = new QApiHandler(Auth::user());
        $book = new Book($handler->getBook($book_id));

        $handler->deleteBook($book_id);
        return redirect('books')->with('book_deleted', $book);
    }
}
