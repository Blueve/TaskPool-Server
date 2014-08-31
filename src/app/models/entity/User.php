<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;

class User extends Eloquent implements UserInterface 
{
	protected $table   = 'tp_users';
	
	public $timestamps = false;

	//////////////////////////////////////////////////////////
	// 关系
	//////////////////////////////////////////////////////////
	public function taskLists()
	{
		return $this->hasMany('TaskList');
	}

	public function userLists()
	{
		return $this->hasMany('UserList');
	}

	//////////////////////////////////////////////////////////
	// 静态方法
	//////////////////////////////////////////////////////////
	/**
	 * 根据用户名获取用户
	 * 
	 * @param  string $name 用户名
	 * @return User         用户
	 */
	public static function retrieveByName($name)
	{
		$user = User::where('name', '=', $name)->first();
		// 检查用户是否存在，不存在则抛出异常
		if($user)
		{
			return $user;
		}
		else
		{
			throw new UserNotFoundException();
		}
	}

	/**
	 * 根据电子邮件获取用户
	 * 
	 * @param  string $email 电子邮件
	 * @return User          用户
	 */
	public static function retrieveByEmail($email)
	{

		$user =  User::where('email', '=', $email)->first();
		// 检查用户是否存在，不存在则抛出异常
		if($user)
		{
			return $user;
		}
		else
		{
			throw new UserNotFoundException();
		}
	}

	/**
	 * 根据用户名或电子邮件获取用户
	 *
	 * 根据输入的字符串自动判断用户输入的数据种类（用户名/电子邮件），
	 * 并据此调用不同的获取用户方法获取用户。
	 * 
	 * @param  string $str 用户名/电子邮件
	 * @return User        用户
	 */
	public static function retrieveByNameOrEmail($str)
	{
		$rule = array('userId' => 'email');
		$input = array('userId' => $str);
		$validator = Validator::make($input, $rule);
		if($validator->fails())
		{
			// 判定为使用用户名登陆
			return User::retrieveByName($str);
		}
		else
		{
			// 判定为使用邮箱登陆
			return User::retrieveByEmail($str);
		}
	}

	/**
	 * 根据注册表单创建一个新用户
	 *
	 * 根据表单在数据库中创建新的用户，创建完毕后向该用户注册时所
	 * 填写的Email地址发送一封确认邮件，同时将验证信息记录到数据
	 * 库中。
	 * 
	 * @param  SignupForm $signupForm 注册表单
	 * @return User                   新注册的用户
	 */
	public static function newUser(SignupForm $signupForm)
	{
		// 校验表单
		if($signupForm->fails()) 
		{
			throw new SignupFailedException();
		}

		// 在数据库创建新的用户
		$user = new User;
		$user->name = $signupForm->name;
		$user->email = $signupForm->email;
		list($user->psw_hash, $user->psw_salt) = Helper::HashPassword($signupForm->password);
		$user->created_at = date('Y-m-d H:i:s', time());
		$user->confirmed = false;
		$user->save();

		// 向该用户发送注册验证邮件
		$toBeConfirmed = ToBeConfirmed::newSignupConfirm($user->id);
		$mailData = array(
						'userId'    => $user->id,
						'checkCode' => $toBeConfirmed->check_code,
					);
		Mail::send('emails.welcome', $mailData, function($message) use($user)
		{
			$message->to($user->email)->subject(Lang::get('site.signup_email_subject'));
		});

		return $user;
	}

	/**
	 * 将一个用户的验证状态标记为已完成
	 * 
	 * @param  int $userId 用户Id
	 * @return void
	 */
	public static function confirmUser($userId)
	{
		User::where('id', '=', $userId)->update(array('confirmed' => true));
	}

	/**
	 * 根据登录表单验证一个用户
	 *
	 * 当验证成功之后，将该用户的Session保持下来（根据表单中的remeberMe
	 * 决定保存的时间限制），成功完成该方法的调用后，被验证的用户将处于
	 * 已登录状态。
	 * 
	 * @param  SigninForm $signinForm 登录表单
	 * @return void
	 */
	public static function auth(SigninForm $signinForm)
	{
		// 对输入进行校验
		$user = User::retrieveByNameOrEmail($signinForm->userId);

		$credentials = array(
			'id' => $user['id'], 
			'password' => $signinForm->password);

		// 尝试验证
		if(!Auth::attempt($credentials, $signinForm->rememberMe))
		{
			throw new AuthFailedException();
		}
	}

	/**
	 * 设置新密码表单处理
	 * 
	 * @param  SetPasswordForm $setPasswordForm 设置新密码表单
	 * @return void
	 */
	public static function setNewPassword(SetPasswordForm $setPasswordForm)
	{
		if($setPasswordForm->isValid())
		{
			$user = User::find($setPasswordForm->userId);
			if(!$user)
			{
				throw new UserNotFoundException();
			}
			$toBeConfirmed = ToBeConfirmed::retrieveFindPswConfirm(
												$setPasswordForm->userId, 
												$setPasswordForm->checkCode);
			if($toBeConfirmed->isFindPswConfirmExpired())
			{
				ToBeConfirmed::destroy($toBeConfirmed->id);
				throw new ToBeConfirmedExpiredException();
			}
			// 更新密码
			$user->updatePassword($setPasswordForm->password);
		}
		else
		{
			throw new PasswordInvalidException();
		}
	}

	//////////////////////////////////////////////////////////
	// 内部方法
	//////////////////////////////////////////////////////////
	/**
	 * 更新当前用户的密码
	 * 
	 * @param  SettingEditForm $settingEditForm 密码设置表单
	 * @return void
	 */
	public function updatePassword(SettingEditForm $settingEditForm)
	{
		// 校验表单
		if($settingEditForm->isValid())
		{
			// 检查旧密码输入是否正确
			if(Helper::CheckPassword($this->psw_hash, 
									 $this->psw_salt, 
									 $settingEditForm->oldPassword))
			{
				// 产生新的密码Hash和Salt
				list($user->psw_hash, $user->psw_salt) = Helper::HashPassword($password);
				$this->save();
				// 退出登录
				Auth::logout();
			}
			else
			{
				throw new AuthFailedException();
			}
		}
		else
		{
			throw new PasswordInvalidException();
		}
	}

	/**
	 * 获取当前用户的全部用户列表
	 * 
	 * @return UserList[] 用户列表集
	 */
	public function allLists()
	{
		return $this->userLists()->orderBy('priority', 'asc')->get();
	}

	/**
	 * 按照List Id 的顺序获取当前用户列表
	 *
	 * 通过该方法获取的用户列表集是按照list_id升序排列的
	 * 
	 * @return UserList[] 用户列表集
	 */
	public function allListsById()
	{
		return $this->userLists()->orderBy('list_id', 'asc')->get();
	}

	/**
	 * 获取当前用户列表的数目
	 * 
	 * @return int 用户列表数目
	 */
	public function getUserListCount()
	{
		return $this->userLists()->count();
	}

	/**
	 * 检查当前的用户列表是否与给定的用户列表一致
	 *
	 * 依据list_id进行一一对照，如果存在与输入不一致的情况，则认为
	 * 输入的数据是不合法的
	 * 
	 * @param  int[]    $userLists 用户列表id的集合
	 * @return boolean             是否一致
	 */
	public function checkUserLists($userLists)
	{
		$count = count($userLists);
		if($count == $this->getUserListCount())
		{
			asort($userLists);
			$i = 0;
			
			$dbUserLists = $this->allListsById();
			foreach($userLists as $key => $val) 
			{
				if($val == $dbUserLists[$i]->list_id)
				{
					$i++;
				}
				else
				{
					return false;
				}
			}
			return true;
		}
		return false;
	}

	/**
	 * 找回密码表单验证
	 *
	 * 验证找回密码表单并向关联的邮箱发送一封包含验证码的邮件
	 * 
	 * @param  FindPasswordForm $findPasswordForm 找回密码表单
	 * @return void
	 */
	public function findPassword(FindPasswordForm $findPasswordForm)
	{
		if($findpasswordForm->isValid())
		{
			$user = User::retrieveByEamil($findpasswordForm->email);
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
		}
		else
		{
			throw new EmailInvalidException();
		}
	}

	//////////////////////////////////////////////////////////
	// UserInterface实现
	//////////////////////////////////////////////////////////
	public function getAuthIdentifier()
	{
		return $this->id;
	}

	public function getAuthPassword()
	{
		return array(
				'psw_hash' => $this->psw_hash,
				'psw_salt' => $this->psw_salt
				);
	}

	public function getRememberToken()
	{
		return $this->remember_token;
	}

	public function setRememberToken($value)
	{
		$this->remember_token = $value;
		$this->save();
	}

	public function getRememberTokenName()
	{
		return 'remember_token';
	}
}
