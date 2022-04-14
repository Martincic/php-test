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
        dd($book->author);
    }
}
