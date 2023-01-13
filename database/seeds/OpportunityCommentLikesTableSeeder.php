<?php

use Illuminate\Database\Seeder;

class OpportunityCommentLikesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\OpportunityCommentLike::class, 500)->create();
    }
}
