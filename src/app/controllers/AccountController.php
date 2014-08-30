<?php

class AccountController extends BaseController
{
	/**
	 * 登录表单处理
	 * 
	 * @return View 提示页面
	 */
	public function signin_post()
	{
		try
		{
			// 验证登录表单
			User::auth(new SigninForm(Input::all()));
			return $this->NoticeResponse('base.signin', Notice::success, 'signin_success');
		}
		catch(UserNotFoundException $e)	// 找不到用户
		{
			return $this->NoticeResponse('base.signin', Notice::danger, 'signin_error');
		}
		catch(AuthFailedException $e)	// 密码错误
		{
			return $this->NoticeResponse('base.signin', Notice::danger, 'signin_error');
		}
	}

	/**
	 * 注册表单处理
	 * 
	 * @return View 提示页面
	 */
	public function signup_post()
	{
		try
		{
			// 添加新用户
			$user = User::newUser(new SignupForm(Input::all()));
			return $this->NoticeResponse('base.signin', Notice::success, 'signin_success',
										 array('title' => 'signup_success', 
											   'data'  => array('email' => $user->email)));
		}
		catch(SignupFailedException $e)	// 输入不合法
		{
			return $this->NoticeResponse('base.signup', Notice::danger, 'signup_error');
		}
	}

	/**
	 * 退出登录
	 * 
	 * @return View 提示页面
	 */
	public function signout()
	{
		Auth::logout();
		return $this->NoticeResponse('base.signout', Notice::success, 'signout_success');
	}

	/**
	 * 验证用户
	 * 
	 * @param  int    $userId    用户Id
	 * @param  string $checkCode 验证码
	 * @return View              提示页面
	 */
	public function confirm($userId, $checkCode)
	{
		try
		{
			// 验证该用户
			ToBeConfirmed::confirmUser($userId, $checkCode);
			return $this->NoticeResponse('base.confirm', Notice::success, 'confirm_success');
		}
		catch(ToBeConfirmedNotFoundException $e)	// 待验证条目未找到
		{
			return $this->NoticeResponse('base.confirm', Notice::danger, 'confirm_error');
		}
		catch(ToBeConfirmedExpiredException $e)		// 待验证条目已过期
		{
			return $this->NoticeResponse('base.confirm', Notice::danger, 'confirm_expired',
										 'user/reconfirm', array($userId, $checkCode));
		}
	}

	/**
	 * 重新用户验证
	 * 
	 * @param  int    $userId    用户Id
	 * @param  string $checkCode 验证码
	 * @return View              提示页面
	 */
	public function reconfirm($userId = null, $checkCode = null)
	{
		try
		{
			// 重新验证用户
			ToBeConfirmed::reconfirmUser($userId, $checkCode);
			return $this->NoticeResponse('base.confirm', Notice::success, 'reconfirm_success');
		}
		catch(AuthFailedException $e)	// 参数为空时用户未登录
		{
			return $this->NoticeResponse('base.reconfirm', Notice::danger, 'confirm_error');
		}
		catch(ToBeConfirmedNotFoundException $e)	// 待验证条目未找到
		{
			return $this->NoticeResponse('base.reconfirm', Notice::danger, 'confirm_error');
		}
	}

	/**
	 * 未通过验证页面
	 * @param  int    $userId    用户Id
	 * @param  string $checkCode 验证码
	 * @return View              提示页面
	 */
	public function unconfirmed($userId, $checkCode)
	{
		return $this->NoticeResponse('base.unconfirmed', Notice::warning, 'unconfirmed', 'reconfirm');
	}

	/**
	 * 找回密码页面
	 *
	 * 无参数时显示提交找回密码的表单页面，有参数的时候显示设置
	 * 新密码页面
	 * 
	 * @param  int    $userId    用户Id
	 * @param  string $checkCode 验证码
	 * @return View              普通视图/提示页面
	 */
	public function findPassword($userId = null, $checkCode = null)
	{
		// 无参数时显示提交找回密码表单页面
		if($userId === null && $checkCode === null)
		{
			$this->MergeData(Lang::get('base.findpassword'));
			return View::make('user.findpassword', $this->data);
		}
		
		// 有参数时显示设置新密码页面
		try
		{
			ToBeConfirmed::findPasswordConfirm($userId, $checkCode);
			$this->MergeData(Lang::get('base.findpassword'));
			$this->data['userId'] = $userId;
			$this->data['checkCode'] = $checkCode;
			return View::make('user.setnewpassword', $this->data);
		}
		catch(ToBeConfirmedNotFoundException $e)	// 待验证条目未找到
		{
			return $this->NoticeResponse('base.findpassword', Notice::danger, 'findpsw_error');
		}
		catch(ToBeConfirmedExpiredException $e)		// 请求已过期
		{
			return $this->NoticeResponse('base.findpassword', Notice::danger, 'findpsw_expired');
		}
	}

	/**
	 * 找回密码表单处理
	 *
	 * 接收找回密码表单并进行处理，向丢失密码的用户的邮箱
	 * 发送一封Email，用于找回密码
	 * 
	 * @return View 提示页面
	 */
	public function findPassword_post()
	{
		try
		{
			User::findPassword(new FindPasswordForm(Input::all()));
			return $this->NoticeResponse('base.findpassword', Notice::success, 
										 array('title' => 'findpsw_success', 
											   'data'  => array('email' => $user->email)));
		}
		catch(EmailInvalidException $e)	// 邮箱格式不正确
		{
			return $this->NoticeResponse('base.findpassword', Notice::danger, 'findpsw_invalid');
		}
		catch(UserNotFoundException $e) // 用户不存在
		{
			return $this->NoticeResponse('base.findpassword', Notice::danger, 'findpsw_miss');
		}
	}

	/**
	 * 设置新密码表单处理
	 *
	 * @return View 提示页面
	 */
	public function setNewPassword_post()
	{
		try
		{
			// 给指定用户设定新的密码
			User::setNewPassword(new SetPasswordForm(Input::all()));
			return $this->NoticeResponse('base.findpassword', Notice::success, 'setpsw_success');
		}
		catch(UserNotFoundException $e)	// 未找到用户
		{
			return $this->NoticeResponse('base.findpassword', Notice::danger, 'setpsw_error');
		}
		catch(PasswordInvalidException $e)	// 密码格式不正确
		{
			return $this->NoticeResponse('base.findpassword', Notice::danger, 'setpsw_invalid');
		}
		catch(ToBeConfirmedNotFoundException $e)	// 未找到找回密码待验证条目
		{
			return $this->NoticeResponse('base.findpassword', Notice::danger, 'setpsw_error');
		}
		catch(ToBeConfirmedExpiredException $e)		// 找回密码待验证条目过期
		{
			return $this->NoticeResponse('base.findpassword', Notice::danger, 'findpsw_expired');
		}
	}
}
