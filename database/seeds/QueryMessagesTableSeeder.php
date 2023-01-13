<?php

use Illuminate\Database\Seeder;

class QueryMessagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\QueryMessage::class, 5000)->create();
    }
}
