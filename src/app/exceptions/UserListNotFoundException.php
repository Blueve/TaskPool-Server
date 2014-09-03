<?php

class UserListNotFoundException extends Exception
{
	public function __construct()
	{
		parent::__construct('User List Not Found');
	}
}