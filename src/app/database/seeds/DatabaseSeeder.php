<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$this->call('UserTableSeeder');
		$this->command->info('User table seeded!');

	}

}

class UserTableSeeder extends Seeder {

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
	}
}