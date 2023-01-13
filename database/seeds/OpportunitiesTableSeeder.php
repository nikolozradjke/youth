<?php

use App\Category;
use App\Company;
use App\Region;
use Illuminate\Database\Seeder;

class OpportunitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Opportunity::class, 50)->create()->each(function ($opportunity) {
            $regions = Region::select('id')->get()->toArray();
            $categories = Category::select('id')->get()->toArray();
            $companies = Company::select('id')->get()->toArray();

            for ($i = 0; $i < rand(1, 5); $i++) {
                $opportunity->regions()->attach($regions[array_rand($regions)]);
            }
            for ($i = 0; $i < rand(1, 5); $i++) {
                $opportunity->categories()->attach($categories[array_rand($categories)]);
            }
            for ($i = 0; $i < rand(1, 5); $i++) {
                $opportunity->company()->associate($companies[array_rand($companies)]['id']);
            }
            $opportunity->query_id = 1; # default query id
            $opportunity->save();
            //$user->roles()->save(factory(App\Role::class)->make());
        });
    }
}
