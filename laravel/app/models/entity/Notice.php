<?php

class Notice{

	private $data;

	const success = "success";
	const info = "info";
	const warning = "warning";
	const danger = "danger";

	public function __construct($type, $arr, $route = '/', $routeValue = array())
	{
		$this->data = array(
				'noticeType' => $type,
				'noticeTitle' => $arr['title'],
				'noticeContent' => $arr['content'],
				'noticeRoute' => $route,
				'noticeRouteValue' => $routeValue,
			);

	}

	public function getData()
	{
		return $this->data;
	}
}