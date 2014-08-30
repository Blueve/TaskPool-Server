<?php

class EmailInvalidException extends Exception
{
	public function __construct()
	{
		parent::__construct('Email Invalid');
	}
}