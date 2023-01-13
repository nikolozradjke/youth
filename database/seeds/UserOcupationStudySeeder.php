<?php

use Illuminate\Database\Seeder;
use App\User;

class UserOcupationStudySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $num = 6;
        factory(App\UserOcupationStudy::class, $num)->create();

        foreach (User::all() as $user) {
            $user->user_ocupation_study_id = rand(0, $num);
            $user->save();
        }
    }
}
