<?php

class NewTaskForm extends BaseFormModel
{
	public $listId;
	public $title;
	public $description;
	public $start;
	public $end;
	public $type;

	public function __construct($input)
	{
		$rule = array(
			'listId'      => 'required',
			'title'       => 'required',
			'description' => '',
			'start'       => 'required',
			'end'         => 'required',
			'type'        => '',
			);

		$this->init($input, $rule);
	}
}