<?php

use Illuminate\Database\Seeder;
use App\QueryQuestion;

class QueryQuestionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $queryQuestion = new QueryQuestion([
            'text' => 'შეაფასე შესაძლებლობა და ორგანიზატორები',
            'details' => 'გთხოვთ შეაფასეთ მოცემული შესაძლებლობა 1-დან 5-მდე ქულით'
        ]);
        $queryQuestion->save();

        factory(App\QueryQuestion::class, 10)->create();
    }
}
