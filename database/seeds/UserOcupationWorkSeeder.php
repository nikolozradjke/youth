<?php

use Illuminate\Database\Seeder;
use App\User;

class UserOcupationWorkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $num = 6;
        factory(App\UserOcupationWork::class, $num)->create();

        foreach (User::all() as $user) {
            $user->user_ocupation_work_id = rand(0, $num);
            $user->save();
        }
    }
}
