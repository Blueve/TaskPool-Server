<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;

class User extends Eloquent implements UserInterface {


	protected $table = 'tp_users';

	public $timestamps = false;

	public static function retrieveByName($name)
	{
		return User::where('name', '=', $name)->first();
	}

	public static function retrieveByEmail($email)
	{
		return User::where('email', '=', $email)->first();
	}

	public static function retrieveByNameOrEmail($str)
	{
		$rule = array('userId' => 'email');
		$input = array('userId' => $str);
		$validator = Validator::make($input, $rule);

		if($validator->fails())
		{
			// 判定为使用用户名登陆
			return User::retrieveByName($str);
		}
		else
		{
			// 判定为使用邮箱登陆
			return User::retrieveByEmail($str);
		}
	}

	public static function newUser(SignupForm $signupForm)
	{
		$user = new User;
		$user->name = $signupForm->name;
		$user->email = $signupForm->email;

		list($user->psw_hash, $user->psw_salt) = Helper::HashPassword($signupForm->email);

		$user->created_at = date('Y-m-d H:i:s', time());
		$user->confirmed = false;
		$user->save();
		return $user;
	}

	public static function confirmUser($userId)
	{
		User::where('id', '=', $userId)->update(array('confirmed' => true));
	}

	public function updatePassword($password)
	{
		list($user->psw_hash, $user->psw_salt) = Helper::HashPassword($password);
		$user->save();
	}


	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->id;
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return array(
			'psw_hash' => $this->psw_hash,
			'psw_salt' => $this->psw_salt
			);
	}

	/**
	 * Get the token value for the "remember me" session.
	 *
	 * @return string
	 */
	public function getRememberToken()
	{
		return $this->remember_token;
	}

	/**
	 * Set the token value for the "remember me" session.
	 *
	 * @param  string  $value
	 * @return void
	 */
	public function setRememberToken($value)
	{
		$this->remember_token = $value;
		$this->save();
	}

	/**
	 * Get the column name for the "remember me" token.
	 *
	 * @return string
	 */
	public function getRememberTokenName()
	{
		return 'remember_token';
	}
}
