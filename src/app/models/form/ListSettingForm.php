<?php

class ListSettingForm extends BaseFormModel
{
	public $id;
	public $name;
	public $sortBy;
	public $color;
	public $icon;
	public $share;

	public function __construct($input)
	{
		$icons = implode( ', ', Config::get('iconset.list_icon_set'));
		$rule = array(
			'id'     => 'required',
			'name'   => 'required',
			'sortBy' => 'required|in: important, urgent, date, custom',
			'color'  => 'required|in: red, orange, yellow, green, blue, indigo, purple, black, darkgray, gray',
			'icon'   => 'required|in: '.$icons,
			'share'  => ''
			);

		$this->init($input, $rule);
		$this->share = isset($this->share) ? true : false;
	}
}