<?php

use Illuminate\Database\Seeder;
use App\Region;
use App\Role;
use App\User;
use App\Company;
use App\Category;

class CompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = new Company([
            'name' => 'admin',
            'email' => 'adminCompany@youth.gov.ge',
            'phone' => '000000001',
            'registration_id' => '000000000',
            'number_of_employees_id' => 1,
            'address' => 'address',
            'password' => '$2y$12$Vf6esY7zf/C3PyPAI/b2xOAvz29Pf5I12ugIo2NX9mjrT2bRXF1Te', // password
            'description1' => 'description1',
            'fb_page' => 'http://facebook.com',
            'linkedin_page' => 'http://linkedin.com',
            'web_page' => 'http://youth.test'
        ]);
        $admin->save();

        $companies = [];

        factory(App\Company::class, 50)->create()->each(function ($company) use (&$companies) {
            $roles = Role::select('id')->get()->toArray();
            $company->roles()->attach($roles[array_rand($roles)]);

            $regions = Role::select('id')->get()->toArray();
            for ($i = 0; $i < rand(1, 5); $i++) {
                $company->regions()->attach($regions[array_rand($regions)]);
            }

            $users = User::select('id')->get()->toArray();
            for ($i = 0; $i < rand(1, 5); $i++) {
                $company->users()->attach($users[array_rand($users)]);
            }

            $categories = Category::select('id')->get()->toArray();
            for ($i = 0; $i < rand(1, 5); $i++) {
                $company->categories()->attach($categories[array_rand($categories)]);
            }


            //$user->roles()->save(factory(App\Role::class)->make());

            if (count($companies) >= 10) {

                for ($i = 0; $i < rand(0, 5); $i++) {
                    $company->subscribedCompanies()->attach($companies[array_rand($companies)]);
                }
            }

            $companies[] = $company;
        });
    }
}
