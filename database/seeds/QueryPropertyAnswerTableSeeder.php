<?php

use Illuminate\Database\Seeder;

class QueryPropertyAnswerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\QueryPropertyAnswer::class, 3000)->create();
    }
}