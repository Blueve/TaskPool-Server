<?php


class ToBeConfirmed extends Eloquent {

	protected $table = 'tp_tobeconfirmed';

	public $timestamps = false;

	public static function newSignupConfirm($userId)
	{
		$toBeConfirmed = new ToBeConfirmed;
		$toBeConfirmed->user_id = $userId;
		$toBeConfirmed->check_code = str_random(64);
		$toBeConfirmed->created_at = time();
		$toBeConfirmed->type = 'signup';
		$toBeConfirmed->save();
		return $toBeConfirmed;
	}
}