<?php

class UserController extends BaseController {

	public function signin()
	{
		$this->data['title'] = '首页';
		return View::make('user.signin', $data);
	}

	public function signup()
	{
		// 对输入进行校验
		$input = Input::all();
		$rule = array(
			'email' 			=> 'required|email|unique:tp_users',
			'name' 				=> 'required|min:6|unique:tp_users',
			'password' 			=> 'required|min:8',
			'passwordConfirm' 	=> 'required|same:password'
			);
		$validator = Validator::make($input, $rule);

		if($validator->fails())
		{
			$notice = new Notice(
				'失败',
				'注册没有完成',
				'存在问题: (',
				'你的填写存在问题',
				'/',
				array(),
				'danger'
				);
		}
		else
		{
			// 创建用户账户
			$user = new User;
			$user->name = $input['name'];
			$user->email = $input['email'];
			$user->psw_salt = str_random(8);
			$user->psw_hash = md5($input['password'].$user->psw_salt);
			$user->created_at = date('Y-m-d H:i:s', time());
			$user->confirmed = false;
			$user->save();

			// 发送确认邮件
			$toBeConfirmed = new ToBeConfirmed;
			$toBeConfirmed->user_id = $user->id;
			$toBeConfirmed->check_code = str_random(64);
			$toBeConfirmed->created_at = time();
			$toBeConfirmed->type = 'signin';
			$toBeConfirmed->save();

			$mailData = array(
				'userId' => $user->id,
				'checkCode' => $toBeConfirmed['check_code']
				);
			Mail::send('emails.welcome', $mailData, function($message) use($user)
			{
				$message->to($user->email)->subject("[验证邮箱]欢迎加入Task Pool");
			});

			$notice = new Notice(
				'成功',
				'注册已经完成',
				'好极了!',
				'你已经完成了注册<br />一封邮件已经发送到你的邮箱：<br /><strong>'.($user->email).'</strong><br /> 请尽快查收并进行验证',
				'/',
				array(),
				'success'
				);
		}
		
		$this->data['title'] = '首页';
		$this->data = array_merge($this->data, $notice->getData());
		return View::make('common.notice', $this->data);
	}

	public function confirm($userId, $checkCode)
	{
		$toBeConfirmed = ToBeConfirmed::where('check_code', '=', $checkCode)
										->where('user_id', '=', $userId)
										->first();
		
		if(!$toBeConfirmed /* && (time() - $toBeConfirmed->created_at) < 60 * 60 */ )
		{
			// 修正为已验证状态
			User::where('id', '=', $toBeConfirmed->user_id)->update(array('confirmed' => true));
			// 删除待验证条目
			ToBeConfirmed::destroy($toBeConfirmed->id);

			$notice = new Notice(
				'成功',
				'邮箱确认已经完成',
				'开始使用吧!',
				'你已经完成了注册流程，快来体验Task Pool吧!',
				'/',
				array(),
				'success'
				);
		}
		elseif($toBeConfirmed)
		{
			$notice = new Notice(
				'失败',
				'邮箱确认没有完成',
				'过期了: (',
				'你的验证邮件可能已经过期, 请点击继续，系统将重新发送一封邮件',
				'user/reconfirm',
				array($userId, $checkCode),
				'danger'
				);
		}
		else
		{
			$notice = new Notice(
				'失败',
				'验证环节发生了错误',
				'验证失败: (',
				'你的验证连接不合法',
				'/',
				array(),
				'danger'
				);
		}
		

		$this->data['title'] = '用户确认';
		$this->data = array_merge($this->data, $notice->getData());
		return View::make('common.notice', $this->data);
	}

	public function reconfirm($userId, $checkCode)
	{
		if($userId == '0' && $checkCode == '0')
		{
			// 对于登录后需要重发的用户需要进行额外的操作
			
		}


		$toBeConfirmed = ToBeConfirmed::where('check_code', '=', $checkCode)
										->where('user_id', '=', $userId)
										->first();
		if($toBeConfirmed)
		{
			// 重新发送邮件
			$user = User::find($toBeConfirmed->user_id);

			$toBeConfirmed->check_code = str_random(64);
			$toBeConfirmed->created_at = time();
			$toBeConfirmed->save();
			$mailData = array(
				'userId' => $user->id,
				'checkCode' => $toBeConfirmed['check_code']
				);

			Mail::send('emails.welcome', $mailData, function($message) use($user)
			{
				$message->to($user->email)->subject("[验证邮箱]欢迎加入Task Pool");
			});

			$notice = new Notice(
				'成功',
				'重新发送完成',
				'正在努力!',
				'一封新的确认邮件已经发送到：<br /><strong>'.($user->email).'</strong><br /> 请尽快查收并进行验证',
				'/',
				array(),
				'success'
				);
		}
		else
		{
			$notice = new Notice(
				'失败',
				'验证环节发生了错误',
				'验证失败: (',
				'你的验证连接不合法',
				'/',
				array(),
				'danger'
				);
		}

		$this->data['title'] = '重新发送确认';
		$this->data = array_merge($this->data, $notice->getData());
		return View::make('common.notice', $this->data);
	}


	public function edit()
	{
		
	}

	public function my()
	{
		
	}
}