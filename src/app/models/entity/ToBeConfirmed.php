<?php
class ToBeConfirmed extends Eloquent
{

	protected $table   = 'tp_tobeconfirmed';
	public $timestamps = false;
	
	const signup       = 'signup';
	const findpsw      = 'findpsw';

	//////////////////////////////////////////////////////////
	// 静态方法
	//////////////////////////////////////////////////////////
	/**
	 * 创建新的注册待验证条目
	 * 
	 * @param  int $userId   用户Id
	 * @return ToBeConfirmed 待验证条目
	 */
	public static function newSignupConfirm($userId)
	{
		return self::newConfirm($userId, ToBeConfirmed::signup);
	}

	/**
	 * 创建新的找回密码待验证条目
	 * 
	 * @param  int $userId   用户Id
	 * @return ToBeConfirmed 待验证条目
	 */
	public static function newFindPasswordConfirm($userId)
	{
		return self::newConfirm($userId, ToBeConfirmed::findpsw);
	}

	/**
	 * 创建新的待验证条目
	 * 
	 * @param  int    $userId 用户Id
	 * @param  string $type   待验证条目类型
	 * @return ToBeConfirmed  待验证条目
	 */
	public static function newConfirm($userId, $type)
	{
		$toBeConfirmed = new ToBeConfirmed;
		$toBeConfirmed->user_id = $userId;
		$toBeConfirmed->check_code = str_random(64);
		$toBeConfirmed->created_at = time();
		$toBeConfirmed->type = $type;
		$toBeConfirmed->save();
		return $toBeConfirmed;
	}

	/**
	 * 从数据库中获取指定的注册待验证条目
	 * 
	 * @param  int $userId       用户Id
	 * @param  string $checkCode 验证码
	 * @return ToBeConfirmed     待验证条目
	 */
	public static function retrieveSignupConfirm($userId, $checkCode)
	{
		return self::retrieveConfirm($userId, ToBeConfirmed::signup, $checkCode);
	}

	/**
	 * 从数据库中获取指定的找回密码待验证条目
	 * 
	 * @param  int    $userId    用户Id
	 * @param  string $checkCode 验证码
	 * @return ToBeConfirmed     待验证条目
	 */
	public static function retrieveFindPswConfirm($userId, $checkCode)
	{
		return self::retrieveConfirm($userId, ToBeConfirmed::findpsw, $checkCode);
	}

	/**
	 * 从数据库中获取指定的待验证条目
	 *
	 * 当不指定校验码的时候，根据类型和用户Id取得待验证条目（每种类型的
	 * 待验证条目对于每个用户而言是只能拥有一项的），若指定校验码的时候
	 * 则额外附加验证码这一条件
	 * 
	 * @param  int    $userId    用户Id
	 * @param  string $type      待验证条目类型
	 * @param  string $checkCode 验证码
	 * @return ToBeConfirmed     待验证条目
	 */
	public static function retrieveConfirm($userId, $type, $checkCode = null)
	{
		if($checkCode)
		{
			$toBeConfirmed = ToBeConfirmed::where('type', '=', $type)
								->where('user_id', '=', $userId)
								->first();
		}
		else
		{
			$toBeConfirmed = ToBeConfirmed::where('check_code', '=', $checkCode)
								->where('user_id', '=', $userId)
								->where('type', '=', $type)
								->first();
		}

		if($toBeConfirmed)
		{
			return $toBeConfirmed;
		}
		else
		{
			throw new ToBeConfirmedNotFoundException();
		}
	}

	/**
	 * 验证指定用户
	 *
	 * 检查用户是否需要被验证以及验证是否过期，如果符合验证条件，则将用户
	 * 的验证状态更新为已通过验证。
	 * 
	 * @param  int    $userId    用户Id
	 * @param  string $checkCode 验证码
	 * @return void
	 */
	public static function confirmUser($userId, $checkCode)
	{
		$toBeConfirmed = ToBeConfirmed::retrieveSignupConfirm($userId, $checkCode);

		if($toBeConfirmed->isSignupConfirmExpired())
		{
			throw new ToBeConfirmedExpiredException();
		}
		
		// 更新为已验证状态
		User::confirmUser($toBeConfirmed->user_id);
		// 删除待验证条目
		ToBeConfirmed::destroy($toBeConfirmed->id);
	}

	/**
	 * 重新验证一个用户
	 *
	 * 当已登录的用户激活该操作的时候，参数为空，从Session中获取
	 * 用户的相关信息并据此取得对应的旧待验证条目；若不为空则是未
	 * 登录用户激活的，根据参数取得旧待验证条目。取得后更新条目并
	 * 向目标用户再次发送验证邮件
	 * 
	 * @param  int    $userId    用户Id
	 * @param  string $checkCode 验证码
	 * @return void
	 */
	public static function reconfirmUser($userId, $checkCode)
	{
		if($userId === null && $checkCode === null)
		{
			// 对于登录后需要重发的用户需要进行额外的操作
			if(Auth::check())
			{
				$toBeConfirmed = ToBeConfirmed::retrieveConfirm($userId, ToBeConfirmed::signup);
			}
			else
			{
				throw new AuthFailedException();
			}
		}
		else
		{
			$toBeConfirmed = ToBeConfirmed::retrieveSignupConfirm($userId, $checkCode);
		}

		// 更新已有条目
		$toBeConfirmed->updateSignupConfirm();
		// 重新发送邮件
		$user = User::find($toBeConfirmed->user_id);
		$mailData = array(
						'userId'    => $user->id,
						'checkCode' => $toBeConfirmed->check_code,
					);
		Mail::send('emails.welcome', $mailData, function($message) use($user)
		{
			$message->to($user->email)->subject(Lang::get('signup_email_subject'));
		});
	}

	/**
	 * 找回密码验证
	 *
	 * 根据用户Id及验证码验证找回密码链接的合法性
	 * 
	 * @param  int    $userId    用户Id
	 * @param  string $checkCode 验证码
	 * @return void
	 */
	public static function findPasswordConfirm($userId, $checkCode)
	{
		$toBeConfirmed = ToBeConfirmed::retrieveFindPswConfirm($userId, $checkCode);

		if($toBeConfirmed->isFindPswConfirmExpired())
		{
			// 删除过期的待验证条目
			ToBeConfirmed::destroy($toBeConfirmed->id);
			throw new ToBeConfirmedExpiredException();
		}
	}

	//////////////////////////////////////////////////////////
	// 内部方法
	//////////////////////////////////////////////////////////
	/**
	 * 更新当前的注册待验证条目
	 * 
	 * @return [type] [description]
	 */
	public function updateSignupConfirm()
	{
		$this->check_code = str_random(64);
		$this->created_at = time();
		$this->save();
	}

	/**
	 * 判断当前注册待验证条目是否已经过期
	 * 
	 * @return boolean 是否过期
	 */
	public function isSignupConfirmExpired()
	{
		return $this->isExpired(Config::get('site.confirm_limit'));
	}

	/**
	 * 判断当前找回密码待验证条目是否已经过期
	 * 
	 * @return boolean 是否过期
	 */
	public function isFindPswConfirmExpired()
	{
		return $this->isExpired(Config::get('site.findpsw_limit'));
	}

	/**
	 * 判断当前带验证条目是否已经超过了指定时间限制
	 * 
	 * @param  int     $limit 时间限制（秒）
	 * @return boolean        是否过期
	 */
	public function isExpired($limit)
	{
		return Helper::IsExpired($this->created_at, $limit);
	}
}
