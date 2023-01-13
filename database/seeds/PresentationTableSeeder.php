<?php

use Illuminate\Database\Seeder;
use App\Presentation;

class PresentationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Presentation::create(['title' => 'Youth Presentation']);
        Presentation::create(['title' => 'Company Presentation']);
    }
}
