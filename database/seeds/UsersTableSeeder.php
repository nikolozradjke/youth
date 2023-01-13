<?php

use App\User;
use App\Role;
use App\Category;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $admin = new User([
            'first_name' => 'admin',
            'last_name' => 'admin',
            'birth_date' => '2020-01-09',
            'email' => 'admin@youth.gov.ge',
            //'email_verified_at' => now(),
            'private_number' => '00000000000',
            'gender' => 'male',
            'phone' => '000000000',
            'password' => '$2y$12$Vf6esY7zf/C3PyPAI/b2xOAvz29Pf5I12ugIo2NX9mjrT2bRXF1Te', // password
            'is_complete' => 1
        ]);
        $admin->save();

        factory(App\User::class, 50)->create()->each(function ($user) {
            $roles = Role::select('id')->get()->toArray();
            $categories = Category::select('id')->get()->toArray();

            $user->roles()->attach($roles[array_rand($roles)]);

            for($i = 0; $i < rand(1,5); $i++) {
                $user->categories()->attach($categories[array_rand($categories)]);
            }
            //$user->roles()->save(factory(App\Role::class)->make());
        });
    }
}
