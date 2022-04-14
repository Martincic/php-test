<?php

namespace App\Util;

use App\Models\ApiUser;
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

    protected function response($data)
    {
        return $data->successful() ? $data->json() : null;
    }
}