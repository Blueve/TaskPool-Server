<?php


class ToBeConfirmed extends Eloquent {

	protected $table = 'tp_tobeconfirmed';
	public $timestamps = false;

	const signup = 'signup';
	const findpsw = 'findpsw';

	public static function newSignupConfirm($userId)
	{
		return self::newConfirm($userId, ToBeConfirmed::signup);
	}

	public static function newFindPasswordConfirm($userId)
	{
		return self::newConfirm($userId, ToBeConfirmed::findpsw);
	}

	public static function newConfirm($userId, $type)
	{
		$toBeConfirmed = new ToBeConfirmed;
		$toBeConfirmed->user_id = $userId;
		$toBeConfirmed->check_code = str_random(64);
		$toBeConfirmed->created_at = time();
		$toBeConfirmed->type = $type;
		$toBeConfirmed->save();
		return $toBeConfirmed;
	}

	public static function retrieveSignupConfirm($userId, $checkCode)
	{
		return self::retrieveConfirm($userId, ToBeConfirmed::signup, $checkCode);
	}

	public static function retrieveFindPswConfirm($userId, $checkCode)
	{
		return self::retrieveConfirm($userId, ToBeConfirmed::findpsw, $checkCode);
	}

	public static function retrieveConfirm($userId, $type, $checkCode = null)
	{
		if($checkCode)
		{
			return ToBeConfirmed::where('type', '=', $type)
								->where('user_id', '=', $userId)
								->first();
		}
		else
		{
			return ToBeConfirmed::where('check_code', '=', $checkCode)
								->where('user_id', '=', $userId)
								->where('type', '=', $type)
								->first();
		}
	}

	public function updateSignupConfirm()
	{
		$this->check_code = str_random(64);
		$this->created_at = time();
		$this->save();
	}

	public function isSignupConfirmExpired()
	{
		return $this->isExpired(Config::get('site.confirm_limit'));
	}

	public function isFindPswConfirmExpired()
	{
		return $this->isExpired(Config::get('site.findpsw_limit'));
	}

	public function isExpired($limit)
	{
		return Helper::isExpired($this->created_at, $limit);
	}
}