<?php

class UserController extends BaseController {

	public function home()
	{
		$this->data['taskLists'] = Auth::user()->allLists();
		$this->MergeData(Lang::get('base.home'));
		return View::make('user.home', $this->data);
	}

	public function setting()
	{
		$this->MergeData(Lang::get('base.setting_edit'));
		return View::make('user.setting', $this->data);
	}

	public function setting_post()
	{
		$settingEditForm = new SettingEditForm(Input::all());
		if($settingEditForm->isValid())
		{
			$user = Auth::user();
			if(Helper::CheckPassword($user->psw_hash, 
									 $user->psw_salt, 
									 $settingEditForm->oldPassword))
			{
				$user->updatePassword($SettingEditForm->password);
				Auth::logout();
				$notice = new Notice(Notice::success, Lang::get('changepsw_success'));
			}
			else
			{
				$notice = new Notice(Notice::danger, Lang::get('changepsw_oldpsw_invalid'));
			}
		}
		else
		{
			$notice = new Notice(Notice::danger, Lang::get('changepsw_invalid'), 'user/setting');
		}

		$this->MergeData(Lang::get('base.setting_edit'));
		$this->MergeData($notice->getData());
		return View::make('common.notice', $this->data);
	}
}