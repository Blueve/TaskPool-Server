<?php

class ListSettingInvalidException extends Exception
{
	public function __construct()
	{
		parent::__construct('List Setting Invalid');
	}
}