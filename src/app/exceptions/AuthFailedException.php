<?php

class AuthFailedException extends Exception
{
	public function __construct()
	{
		parent::__construct('Auth Failed');
	}
}