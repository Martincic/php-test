<?php

namespace App\Providers;

use App\Models\ApiUser;
use Illuminate\Auth\GenericUser;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class QAuthUserProvider implements UserProvider
{
	public function retrieveById($id) : ApiUser
	{
		//if user matches session user, fetch
		if(session('user')->id == $id) return session('user');
		
		//else return generic
		return new GenericUser(['remember_token'=>null]);
	}

	public function retrieveByToken($id, $token) : void
	{
		// user provider interface requires
	}

	public function updateRememberToken($user, $token) : void
	{
		// user provider interface requires
	}

	public function retrieveByCredentials(array $credentials) : ?ApiUser
	{
		$response = Http::post(env("Q_API"), [
            // $user is the ApiUser instance created in
            // the retrieveByCredentials() method above.
            'email' => $credentials['email'],
            'password' => $credentials['password'],
        ])->json();

		$user = new ApiUser($response);

		session(['user' => $user]);
		
		return $user;
	}

	public function validateCredentials(Authenticatable $user, array $credentials)
	{
		//this is called after retrieveByCredentials,
		//thus if api fails, this is never called
		return true;
	}
}