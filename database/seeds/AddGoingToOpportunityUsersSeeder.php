<?php

use Illuminate\Database\Seeder;

use App\User;
use App\Opportunity;

class AddGoingToOpportunityUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        $opportunities = Opportunity::all();
        foreach($opportunities as $opp){
            $x = rand(0, $users->count());
            $selectedUsers = $users->random($x);
            foreach($selectedUsers as $user){
                $user->addGoingOpportunity($opp->id);
            }
        }
    }
}
