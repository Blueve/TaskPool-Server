<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;

class User extends Eloquent implements UserInterface {


	protected $table = 'tp_users';

	public $timestamps = false;

	/*
	 * 关系
	 */
	public function tasklists()
	{
		return $this->hasMany('TaskList');
	}

	/*
	 * 静态方法
	 */
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

		list($user->psw_hash, $user->psw_salt) = Helper::HashPassword($signupForm->password);

		$user->created_at = date('Y-m-d H:i:s', time());
		$user->confirmed = false;
		$user->save();
		return $user;
	}

	public static function confirmUser($userId)
	{
		User::where('id', '=', $userId)->update(array('confirmed' => true));
	}


	/*
	 * 对象内部方法
	 */
	public function updatePassword($password)
	{
		list($user->psw_hash, $user->psw_salt) = Helper::HashPassword($password);
		$user->save();
	}

	public function allLists()
	{
		return $this->tasklists()->orderBy('priority', 'asc')->get();
	}


	/*
	 * UserInterface 实现
	 */
	public function getAuthIdentifier()
	{
		return $this->id;
	}


	public function getAuthPassword()
	{
		return array(
			'psw_hash' => $this->psw_hash,
			'psw_salt' => $this->psw_salt
			);
	}

	public function getRememberToken()
	{
		return $this->remember_token;
	}

	public function setRememberToken($value)
	{
		$this->remember_token = $value;
		$this->save();
	}

	public function getRememberTokenName()
	{
		return 'remember_token';
	}
}
