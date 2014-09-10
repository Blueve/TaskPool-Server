<?php

class UserController extends BaseController
{
	/**
	 * 用户主页
	 *
	 * 用户登陆后显示的
	 * 
	 * @return [type] [description]
	 */
	public function home()
	{
		// 读取登录用户的全部用户列表
		$this->data['userLists'] = Auth::user()->allLists();

		$this->MergeData(Lang::get('base.home'));
		return View::make('user.home', $this->data);
	}

	/**
	 * 设置页面
	 *
	 * 提供修改密码服务
	 * 
	 * @return View 页面
	 */
	public function setting()
	{
		$this->MergeData(Lang::get('base.setting_edit'));
		return View::make('user.setting', $this->data);
	}

	/**
	 * 修改密码表单处理
	 * 
	 * @return View 提示页面
	 */
	public function setting_post()
	{
		try
		{
			Auth::user()->updatePassword(new SettingEditForm(Input::all()));
			return $this->NoticeResponse('base.setting_edit', Notice::success, 'changepsw_success');
		}
		catch(AuthFailedException $e)
		{
			return $this->NoticeResponse('base.setting_edit', Notice::danger, 'changepsw_oldpsw_invalid', 'user/setting');
		}
		catch(PasswordInvalidException $e)
		{
			return $this->NoticeResponse('base.setting_edit', Notice::danger, 'changepsw_invalid', 'user/setting');
		}
	}
}