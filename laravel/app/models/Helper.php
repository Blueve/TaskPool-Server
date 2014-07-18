<?php

class Helper
{
	static public function HashPassword($password)
	{
		$psw_salt = str_random(8);
		$psw_hash = md5($password.$psw_salt);
		return array($psw_hash, $psw_salt);
	}
}