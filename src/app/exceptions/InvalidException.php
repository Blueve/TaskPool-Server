<?php

class InvalidException extends Exception
{
	public function __construct()
	{
		parent::__construct('Invalid');
	}
}