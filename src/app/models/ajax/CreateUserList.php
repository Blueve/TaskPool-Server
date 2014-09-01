<?php

class CreateUserList
{
	public $state;
	public $id;
	public $name;
	public $icon;
	public $shared;

	public  function __construct($state, $id = '', $name = '', $icon = '', $shared = '')
	{
		$this->state  = $state;
		$this->id     = $id;
		$this->name   = $name;
		$this->icon   = $icon;
		$this->shared = $shared;
	}
}