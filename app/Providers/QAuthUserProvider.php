<?php

namespace App\Providers;

use App\Models\ApiUser;
use App\Util\QApiHandler;
use Illuminate\Auth\GenericUser;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Auth\Authenticatable;

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
		$handler = new QApiHandler;
		$response = $handler->attemptLogin($credentials);
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