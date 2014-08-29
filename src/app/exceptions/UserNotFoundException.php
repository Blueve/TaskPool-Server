<?php

class UserNotFoundException extends Exception
{
	public function __construct()
	{
		parent::__construct('User Not Found');
	}
}