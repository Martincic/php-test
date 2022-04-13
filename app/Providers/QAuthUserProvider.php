<?php

namespace App\Providers;

use Illuminate\Auth\GenericUser;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Http;

class QAuthUserProvider implements UserProvider
{
	public function retrieveById($id) : GenericUser
	{
		return new GenericUser([
			'id' => $id,
			'email' => $id
		]);
	}

	public function retrieveByToken($id, $token) : void
	{
		// user provider interface requires
	}

	public function updateRememberToken($user, $token) : void
	{
		// user provider interface requires
	}

	public function retrieveByCredentials(array $credentials) : GenericUser
	{
		if(!empty($credentials['email'])) return new GenericUser([
			'id' => $credentials['email'],
			'email' => $credentials['email']
		]);

		return new GenericUser([
			'id' => $credentials['email'],
			'email' => $credentials['email']
		]);
	}

	public function validateCredentials(Authenticatable $user, array $credentials)
	{
		if(empty($credentials['password'])) return false;
		
		$response = Http::post(env("Q_API"), [
            // $user is the GenericUser instance created in
            // the retrieveByCredentials() method above.
            'email' => $user->email,
            'password' => $credentials['password'],
        ]);

        return $response->ok();
	}
}