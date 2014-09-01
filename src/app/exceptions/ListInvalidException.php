<?php

class ListInvalidException extends Exception
{
	public function __construct()
	{
		parent::__construct('List Invalid');
	}
}