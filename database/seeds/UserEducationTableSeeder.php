<?php

use App\UserEducation;
use Illuminate\Database\Seeder;

class UserEducationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserEducation::create(['name' => ['ka'=> 'სკოლა', 'en' => 'School']]);
        UserEducation::create(['name' => ['ka'=> 'პროფესიული განათლება', 'en' => 'Professional Education']]);
        UserEducation::create(['name' => ['ka'=> 'უნივერსიტეტი - ბაკალავრიატი', 'en' => 'University - Bachelor']]);
        UserEducation::create(['name' => ['ka'=> 'უნივერსიტეტი - მაგისტრატურა', 'en' => 'University - Master']]);
        UserEducation::create(['name' => ['ka'=> 'უნივერსიტეტი - დოქტორანტურა', 'en' => 'University - Doctor']]);
    }
}
