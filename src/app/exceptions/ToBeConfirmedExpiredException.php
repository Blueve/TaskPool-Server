<?php

class ToBeConfirmedExpiredException extends Exception
{
	public function __construct()
	{
		parent::__construct('ToBeConfirmed Expired');
	}
}