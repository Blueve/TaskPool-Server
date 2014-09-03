<?php

class ListSetting
{
	public $state;
	public $name;
	public $sort_by;
	public $color;
	public $icon;
	public $shareable;
	public $shareCode;

	public  function __construct($state, 
								 $name      = '',
								 $sort_by   = '',
								 $color     = '',
								 $icon      = '',
								 $shareable = '',
								 $shareCode = '')
	{
		$this->state     = $state;
		$this->name      = $name;
		$this->sort_by   = $sort_by;
		$this->color     = $color;
		$this->icon      = $icon;
		$this->shareable = $shareable;
		$this->shareCode = $shareCode;
	}
}