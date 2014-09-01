<?php

class ListNotFoundException extends Exception
{
	public function __construct()
	{
		parent::__construct('List Not Found');
	}
}