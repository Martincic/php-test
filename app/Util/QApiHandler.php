<?php

namespace App\Util;

use App\Models\ApiUser;
use App\Models\Book;
use Illuminate\Support\Facades\Http;

class QApiHandler {

    private ?ApiUser $user;

	public function __construct(?ApiUser $user = null)
	{
		$this->client = Http::acceptJson()->baseUrl(env("Q_API"));
        $this->user = $user;
	}

    public function attemptLogin(array $credentials)
    {
        $data = $this->client->post('v2/token', [
            'email' => $credentials['email'],
            'password' => $credentials['password']
        ]);
        return $this->response($data);
    }

    public function createAuthor($data, $token = null)
    {
        $token = $token ?? $this->user->token_key;
        $data = $this->client->withToken($token)->post('v2/authors', $data);
        return $this->response($data);
    }
    
    public function deleteAuthor($id)
    {
        $data = $this->client->withToken($this->user->token_key)->delete('v2/authors/'.$id);
        return $this->response($data);
    }
    
    public function getAuthors()
    {
        $data = $this->client->withToken($this->user->token_key)->get('v2/authors');
        return $this->response($data);
    }

    public function getAuthor($id)
    {
        $data = $this->client->withToken($this->user->token_key)->get('v2/authors/'.$id);
        return $this->response($data);
    }

    public function getBooks()
    {
        $data = $this->client->withToken($this->user->token_key)->get('v2/books');
        return $this->response($data);
    }
    
    public function getBook($id)
    {
        $data = $this->client->withToken($this->user->token_key)->get('v2/books/'.$id);
        return $this->response($data);
    }
    
    public function deleteBook($id)
    {
        $data = $this->client->withToken($this->user->token_key)->delete('v2/books/'.$id);
        return $this->response($data);
    }
    
    public function createBook($data)
    {
        $data = $this->client->withToken($this->user->token_key)->post('v2/books', $data);
        return $this->response($data);
    }

    protected function response($data)
    {
        return $data->successful() ? $data->json() : null;
    }
}