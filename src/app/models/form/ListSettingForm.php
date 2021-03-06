<?php

class ListSettingForm extends BaseFormModel
{
	public $id;
	public $name;
	public $sortBy;
	public $color;
	public $icon;
	public $shareable;

	public function __construct($input)
	{
		$icons = implode( ', ', Config::get('iconset.list_icon_set'));
		$rule = array(
			'id'     => 'required',
			'name'   => 'required',
			'sortBy' => 'required|in:important,urgent,date,custom',
			'color'  => 'required|in:red,orange,yellow,green,blue,indigo,purple,black,darkgray,gray',
			'icon'   => 'required', /**@todo 需要更严格的验证in: {icon set} */
			//'shareable'  => ''
			);

		$this->init($input, $rule);
		$this->shareable = isset($this->shareable) ? true : false;
	}
}