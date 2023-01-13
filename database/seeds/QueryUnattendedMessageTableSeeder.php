<?php

use Illuminate\Database\Seeder;

class QueryUnattendedMessageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\QueryUnattendedMessage::class, 50)->create();
    }
}