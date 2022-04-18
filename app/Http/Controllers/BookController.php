<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Util\QApiHandler;
use GuzzleHttp\Psr7\Request;
use Illuminate\Foundation\Http\FormRequest;
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
        $handler = new QApiHandler(Auth::user());
        
        $book = [
            'title' => $request->title,
            'author' => [
                'id' => intval($request->author)
            ],
            'release_date' => $request->release_date,
            'description' => $request->description,
            'isbn' => $request->isbn,
            'format' => $request->format,
            'number_of_pages' => intval($request->number_of_pages)
        ];

        $book = new Book($handler->createBook($book));
        return view('books.single')->with('book', $book);
    }
}
