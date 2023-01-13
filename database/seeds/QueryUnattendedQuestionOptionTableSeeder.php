<?php

use Illuminate\Database\Seeder;
use App\QueryUnattendedQuestionOption;

class QueryUnattendedQuestionOptionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\QueryUnattendedQuestionOption::class, 8 )->create(['question_id'=>1]);

        $other = new QueryUnattendedQuestionOption([
            'text' => 'სხვა',
            'question_id' => 1,
            'has_text_field' => true
        ]);
        $other->save();
    }
}
