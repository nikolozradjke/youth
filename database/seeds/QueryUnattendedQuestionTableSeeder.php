<?php

use Illuminate\Database\Seeder;
use App\QueryUnattendedQuestion;

class QueryUnattendedQuestionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $question = new QueryUnattendedQuestion([
            'text' => 'რატომ ვერ დაესწარით შესაძლებლობას?',
        ]);
        $question->save();
    }
}
