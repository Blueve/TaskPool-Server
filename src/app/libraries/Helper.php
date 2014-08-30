<?php

class Helper
{
	/**
	 * 在页面上输出指定变量
	 * 
	 * @param  Object $var 需要被输出的变量
	 * @return void
	 */
	public static function VarDump($var)
	{
		echo '<pre>';
		print_r($var);
		echo '</pre>';
	}

	/**
	 * 按照MD5 + Salt的方法对指定明文密码加密
	 * 
	 * @param  string $password 明文密码
	 * @return array            [0]=>密码哈希值,[1]=>密码Salt
	 */
	public static function HashPassword($password)
	{
		$psw_salt = str_random(8);
		$psw_hash = md5($password.$psw_salt);
		return array($psw_hash, $psw_salt);
	}

	/**
	 * 按照MD5 + Salt的方法对指定明文密码和哈希密码进行校验
	 * 
	 * @param  string $psw_hash 密码哈希值
	 * @param  string $psw_salt 密码Salt
	 * @param  string $password 密码明文
	 * @return boolean          是否匹配
	 */
	public static function CheckPassword($psw_hash, $psw_salt, $password)
	{
		return $psw_hash === md5($password.$psw_salt);
	}

	/**
	 * 判断是否过期
	 *
	 * 根据时间限制和起始时间进行判断，若当前时间距离起始时间
	 * 已经超过了时间限制，那么则判定为过期
	 * 
	 * @param  int $date  起始时间戳
	 * @param  int $limit 时间限制（秒）
	 * @return boolean    是否过期
	 */
	public static function IsExpired($date, $limit)
	{
		return (time() - strtotime($date)) < $limit ? false : true ;
	}

	/**
	 * 以Base64算法对ListId进行编码
	 *
	 * 将待编码的ListId进行补零操作后再进行编码，从而确保产生
	 * 的编码不出现特殊符号
	 * 
	 * @param  int $id 列表Id
	 * @return string  编码后的列表Id
	 */
	public static function EncodeListId($id)
	{
		$len = strlen($id);
		$len = $len + (3 - $len % 3);
		return base64_encode(str_pad($id, $len, '0', STR_PAD_LEFT));
	}

	/**
	 * 以Base64算法对ListId进行解码
	 * 
	 * @param  string $code 编码后的列表Id
	 * @return int          解码后的列表Id
	 */
	public static function DecodeListId($code)
	{
		return intval(base64_decode($code));
	}
}