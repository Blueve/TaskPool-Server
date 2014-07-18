<?php

class Notice{

	private $data;

	public function __construct($noticeStatus, $noticeInfo, $title, $content, $route = '', $routeValue, $type = 'info')
	{
		$this->data = array(
			'noticeStatus' => $noticeStatus,
			'noticeInfo' => $noticeInfo,
			'noticeTitle' => $title,
			'noticeContent' => $content,
			'noticeRoute' => $route,
			'noticeRouteValue' => $routeValue,
			'noticeType' => $type
			);
	}

	public function getData()
	{
		return $this->data;
	}
}