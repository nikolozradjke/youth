<?php

use Illuminate\Database\Seeder;

class NumberOfEmployeesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\NumberOfEmployees::class, 50)->create();
    }
}
