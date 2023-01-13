<?php

use App\Query;
use App\QueryOpportunityProperty;
use App\QueryQuestion;
use App\QueryUnattendedQuestion;

use Illuminate\Database\Seeder;

class QueryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $query = new Query([
            'name' => 'Default კითხვარი',
        ]);
        $query->save();

        // Attach Questions for Attended Users
        $questions = QueryQuestion::take(6)->get();
        for ($i=0; $i < sizeof($questions); $i++) {
            $id =$questions[$i]->id;
            $query->questions()->attach([$id => ['order' => $id]]);
        }

        // Attach Questions for Unattended Users
        $unattendedQuestions = QueryUnattendedQuestion::take(1)->get();
        for ($i=0; $i < sizeof($unattendedQuestions); $i++) {
            $id =$unattendedQuestions[$i]->id;
            $query->unattended_questions()->attach([$id => ['order' => $id]]);
        }

        // Attach Properties
        $properties = QueryOpportunityProperty::take(6)->get();
        for ($i = 0; $i < sizeof($properties); $i++) {
            $id =$properties[$i]->id;
            $query->properties()->attach([$id => ['order' => $id]]);
        }
    }
}
