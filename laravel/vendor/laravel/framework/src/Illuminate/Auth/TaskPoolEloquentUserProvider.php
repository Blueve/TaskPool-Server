<?php namespace Illuminate\Auth;

class TaskPoolEloquentUserProvider extends EloquentUserProvider {

	/**
	 * Validate a user against the given credentials.
	 *
	 * @param  \Illuminate\Auth\UserInterface  $user
	 * @param  array  $credentials
	 * @return bool
	 */
	public function validateCredentials(UserInterface $user, array $credentials)
	{
		$plain = $credentials['password'];
		$authPassword = $user->getAuthPassword();
		return $authPassword['psw_hash'] === md5($plain.$authPassword['psw_salt']);
	}

}