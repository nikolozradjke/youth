<?php

use Illuminate\Database\Seeder;

class QueryQuestionAnswerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\QueryQuestionAnswer::class, 2000)->create();
    }
}