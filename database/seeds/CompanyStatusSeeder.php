<?php

use App\CompanyStatus;
use Illuminate\Database\Seeder;

class CompanyStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CompanyStatus::create(['name' => ['ka' => 'ადგილობრივი თვითმმართველობა']]);
        CompanyStatus::create(['name' => ['ka' => 'სამინისტრო']]);
        CompanyStatus::create(['name' => ['ka' => 'არასამეწარმეო (არაკომერციული) იურიდიული პირი(ააიპ) - არასამთავრობო']]);
        CompanyStatus::create(['name' => ['ka' => 'საერთაშორისო ორგანიზაცია']]);
        CompanyStatus::create(['name' => ['ka' => 'არასამეწარმეო (არაკომერციული) იურიდიული პირი(ააიპ) - სამთავრობო']]);
        CompanyStatus::create(['name' => ['ka' => 'სახელმწიფო რწმუნებულის ადმინისტრაცია']]);
        CompanyStatus::create(['name' => ['ka' => 'მეწარმე სუბიექტები']]);
        CompanyStatus::create(['name' => ['ka' => 'საჯარო სამართლის იურიდიული პირი(სსიპ) - საჯარო ინსტიტუტები']]);
        CompanyStatus::create(['name' => ['ka' => 'მთავრობის ადმინისტრაცია']]);
        CompanyStatus::create(['name' => ['ka' => 'საჯარო სამართლის იურიდიცული პირი(სსიპ) - უმაღლესი განათლების დაწესებულება ']]);
        CompanyStatus::create(['name' => ['ka' => 'საელჩო']]);
        CompanyStatus::create(['name' => ['ka' => 'საჯარო სამართლის იურიდიული პირი(სსიპ) - პროფესიული სასწავლებელი']]);
        CompanyStatus::create(['name' => ['ka' => 'სხვა'], 'can_be_filled' => true]);
    }
}
