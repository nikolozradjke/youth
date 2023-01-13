<?php

use Illuminate\Database\Seeder;
use App\User;

class UserOccupationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $num = 4;
        factory(App\UserOccupation::class, $num)->create();

        foreach (User::all() as $user) {
            $user->user_occupation_id = rand(0, $num);
            $user->save();
        }
    }
}
