<?php

class AccountController extends BaseController {

	public function signin()
	{
		// 对输入进行校验
		$signinForm = new SigninForm(Input::all());
		$user = User::retrieveByNameOrEmail($signinForm->userId);

		$notice = new Notice(Notice::danger, 'signin_error');

		if($user)
		{
			$credentials = array(
				'id' => $user['id'], 
				'password' => $signinForm->password);

			// 用户存在
			if(Auth::attempt($credentials, $signinForm->rememberMe))
			{
				// 登陆成功
				$notice = new Notice(Notice::success, 'signin_success');
			}
			
		}

		$this->MergeData(Lang::get('base.signin'));
		$this->MergeData($notice->getData());
		return View::make('common.notice', $this->data);
	}

	public function signup()
	{
		// 对输入进行校验
		$signupForm = new SignupForm(Input::all());

		$notice = new Notice(Notice::danger, 'signup_error');

		if($signupForm->isValid())
		{
			// 创建用户账户
			$user = User::newUser($signupForm);
			// 发送确认邮件
			$toBeConfirmed = ToBeConfirmed::newSignupConfirm($user->id);

			$mailData = array(
							'userId' => $user->id,
							'checkCode' => $toBeConfirmed->check_code,
						);
			Mail::send('emails.welcome', $mailData, function($message) use($user)
			{
				$message->to($user->email)->subject(Lang::get('site.signup_email_subject'));
			});
			$notice = new Notice(Notice::success, 
								array('title' => 'signup_success', 
									  'data'  => array('email' => $user->email)));
		}
		
		$this->MergeData(Lang::get('base.signup'));
		$this->MergeData($notice->getData());
		return View::make('common.notice', $this->data);
	}

	public function signout()
	{
		Auth::logout();
		$notice = new Notice(Notice::success, 'signout_success');

		$this->MergeData(Lang::get('base.signout'));
		$this->MergeData($notice->getData());
		return View::make('common.notice', $this->data);
	}

	public function confirm($userId, $checkCode)
	{
		$toBeConfirmed = ToBeConfirmed::retrieveSignupConfirm($userId, $checkCode);
		
		if($toBeConfirmed && !$toBeConfirmed->isSignupConfirmExpired())
		{
			// 修正为已验证状态
			User::confirmUser($toBeConfirmed->user_id);
			// 删除待验证条目
			ToBeConfirmed::destroy($toBeConfirmed->id);
			$notice = new Notice(Notice::success, 'confirm_success');
		}
		elseif($toBeConfirmed)
		{
			$notice = new Notice(Notice::danger, 'confirm_expired',
								'user/reconfirm', array($userId, $checkCode));
		}
		else
		{
			$notice = new Notice(Notice::danger, 'confirm_error');
		}
		
		$this->MergeData(Lang::get('base.confirm'));
		$this->MergeData($notice->getData());
		return View::make('common.notice', $this->data);
	}

	public function reconfirm($userId = null, $checkCode = null)
	{
		if($userId === null && $checkCode === null)
		{
			// 对于登录后需要重发的用户需要进行额外的操作
			if(Auth::check())
			{
				$toBeConfirmed = ToBeConfirmed::retrieveConfirm($userId, ToBeConfirmed::signup);
			}
		}
		else
		{
			$toBeConfirmed = ToBeConfirmed::retrieveSignupConfirm($userId, $checkCode);
		}

		if($toBeConfirmed)
		{
			// 重新发送邮件
			$user = User::find($toBeConfirmed->user_id);
			// 更新已有条目
			$toBeConfirmed->updateSignupConfirm();
			
			$mailData = array(
							'userId' => $user->id,
							'checkCode' => $toBeConfirmed->check_code,
						);

			Mail::send('emails.welcome', $mailData, function($message) use($user)
			{
				$message->to($user->email)->subject(Lang::get('signup_email_subject'));
			});

			$notice = new Notice(Notice::success, 'reconfirm_success');
		}
		else
		{
			$notice = new Notice(Notice::danger, 'confirm_error');
		}

		$this->MergeData(Lang::get('base.reconfirm'));
		$this->MergeData($notice->getData());
		return View::make('common.notice', $this->data);
	}

	public function unconfirmed($userId, $checkCode)
	{
		$notice = new Notice(Notice::warning, 'unconfirmed', 'reconfirm');

		$this->MergeData(Lang::get('base.unconfirmed'));
		$this->MergeData($notice->getData());
		return View::make('common.notice', $this->data);
	}

	public function findpassword($userId = null, $checkCode = null)
	{
		$this->MergeData(Lang::get('base.findpassword'));

		if($userId === null && $checkCode === null)
		{
			return View::make('user.findpassword', $this->data);
		}
		else
		{
			$toBeConfirmed = ToBeConfirmed::retrieveFindPswConfirm($userId, $checkCode);
			if($toBeConfirmed && !$toBeConfirmed->isFindPswConfirmExpired())
			{
				if($toBeConfirmed->isFindPswConfirmExpired())
				{
					// 删除待验证条目
					ToBeConfirmed::destroy($toBeConfirmed->id);
					$notice = new Notice(Notice::danger, 'findpsw_expired');
				}
				else
				{
					$this->data['userId'] = $userId;
					$this->data['checkCode'] = $checkCode;
					return View::make('user.setnewpassword', $this->data);
				}
				
			}
			else
			{
				$notice = new Notice(Notice::danger, 'findpsw_error');
			}
		}

		$this->MergeData(Lang::get('base.findpassword'));
		$this->MergeData($notice->getData());
		return View::make('common.notice', $this->data);
	}

	public function findpassword_post()
	{
		$findpasswordForm = new FindPasswordForm(Input::all());

		if($findpasswordForm->isValid())
		{
			$user = User::retrieveByEamil($findpasswordForm->email);
			if($user)
			{
				// 发送修改密码的邮件
				$toBeConfirmed = ToBeConfirmed::newFindPasswordConfirm($user->id);
				$mailData = array(
								'userId' => $user->id,
								'checkCode' => $toBeConfirmed->check_code,
							);
				Mail::send('emails.findpsw', $mailData, function($message) use($user)
				{
					$message->to($user->email)->subject(Lang::get('site.findpsw_email_subject'));
				});
				$notice = new Notice(Notice::success, 
									array('title' => 'findpsw_success', 
									'data'  => array('email' => $user->email)));
			}
			else
			{
				$notice = new Notice(Notice::danger, 'findpsw_miss');
			}

		}
		else
		{
			$notice = new Notice(Notice::danger, 'findpsw_invalid', 'findpassword');

		}

		$this->MergeData(Lang::get('base.findpassword'));
		$this->MergeData($notice->getData());
		return View::make('common.notice', $this->data);
	}

	public function setnewpassword()
	{
		$setPasswordForm = new SetPasswordForm(Input::all());
		if($setPasswordForm->isValid())
		{
			$user = User::find($setPasswordForm->userId);
			$toBeConfirmed = ToBeConfirmed::retrieveFindPswConfirm(
				$setPasswordForm->userId, 
				$setPasswordForm->checkCode);
			if($user && $toBeConfirmed)
			{
				$user->updatePassword($setPasswordForm->password);
				ToBeConfirmed::destroy($toBeConfirmed->id);
				$notice = new Notice(Notice::success, 'setpsw_success');
			}
			else
			{
				$notice = new Notice(Notice::danger, 'setpsw_error');
			}
		}
		else
		{
			$notice = new Notice(Notice::danger, 'setpsw_invalid');
		}

		$this->MergeData(Lang::get('base.findpassword'));
		$this->MergeData($notice->getData());
		return View::make('common.notice', $this->data);
	}
}