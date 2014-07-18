<?php namespace Illuminate\Auth;

class TaskPoolEloquentUserProvider extends EloquentUserProvider {

	public function __construct($model)
	{
		$this->model = $model;
	}

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
		return CheckPassword($authPassword['psw_hash'], $authPassword['psw_salt'], $plain); // === md5($plain.$authPassword['psw_salt']);
	}

}