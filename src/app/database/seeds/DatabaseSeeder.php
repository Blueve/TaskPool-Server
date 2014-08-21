<?php

class DatabaseSeeder extends Seeder 
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$this->call('TestSeeder');
		$this->command->info('Test seeded!');

	}

}

class TestSeeder extends Seeder 
{
	public function run()
	{
		// 产生一个通过验证的账号
		$user = new User;
		$user->name = 'tester';
		$user->email = 'tester@example.com';
		list($user->psw_hash, $user->psw_salt) = Helper::HashPassword('123456789');
		$user->created_at = date('Y-m-d H:i:s', time());
		$user->confirmed = true;
		$user->save();
		// 产生另一个通过验证的账号
		$user2 = new User;
		$user2->name = 'tester2';
		$user2->email = 'tester2@example.com';
		list($user2->psw_hash, $user2->psw_salt) = Helper::HashPassword('123456789');
		$user2->created_at = date('Y-m-d H:i:s', time());
		$user2->confirmed = true;
		$user2->save();
		// 给$user添加默认的List
		$listArr = ['工作', '学习', '旅行', '书单', '愿望'];
		foreach ($listArr as $value)
		{
			$listForm = new NewListForm(['name' => $value]);
			TaskList::createByForm($listForm, $user);
		}
		// 给$user2添加默认的List
		$listArr = ['共享1', '共享2', '指派1', '指派2'];
		foreach ($listArr as $value)
		{
			$listForm = new NewListForm(['name' => $value]);
			TaskList::createByForm($listForm, $user2);
		}
	}
}