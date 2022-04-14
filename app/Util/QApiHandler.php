<?php

namespace App\Util;

use Illuminate\Support\Facades\Http;

class QApiHandler {

	public function __construct()
	{
		$this->client = Http::acceptJson()->baseUrl(env("Q_API"));
	}

    public function attemptLogin(array $credentials)
    {
        $data = $this->client->post('v2/token', [
            'email' => $credentials['email'],
            'password' => $credentials['password']
        ]);
        return $this->response($data);
    }

    protected function response($data)
    {
        return $data->successful() ? $data->json() : null;
    }
}