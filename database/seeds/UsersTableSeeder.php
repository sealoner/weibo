<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = factory(User::class)->times(50)->make();
        User::insert($users->makeVisible(['password', 'remember_token'])->toArray());

        //对第一条数据进行更新，方便我们登录
        $user = User::find(1);
        $user->name     = 'Sealone';
        $user->email    = '123@123.com';
        $user->password = bcrypt('123456');
        $user->is_admin= true;
        $user->save();
    }
}
