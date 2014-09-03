<?php

class BaseAjaxModel
{
	public $state;

	public  function __construct($state)
	{
		$this->state  = $state;
	}
}