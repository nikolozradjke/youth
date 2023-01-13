<?php

namespace Tests\Unit;

// use App\Region;
use App\Category;
use App\Company;
use App\Opportunity;
use PHPUnit\Framework\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

use Illuminate\Foundation\Testing\RefreshDatabase;

class OpportunityFilterTest extends TestCase
{
    use RefreshDatabase;

    public function setUp() : void
    {
        parent::setUp();
        
        $regions = factory(\App\Region::class, 5)->create()->toArray();
        $categories = factory(Category::class, 5)->create()->toArray();

        $companies = factory(Company::class, 5)->create()->toArray();

        factory(Opportunity::class, 5)->create()->each(function ($opportunity) {
            for($i = 0; $i < rand(1,5); $i++) {
                $opportunity->regions()->attach($regions[array_rand($regions)]);
            }
            for($i = 0; $i < rand(1,5); $i++) {
                $opportunity->categories()->attach($categories[array_rand($categories)]);
            }
            for($i = 0; $i < rand(1,5); $i++) {
                $opportunity->company()->associate($companies[array_rand($companies)]['id']);
            }
            $opportunity->save();
        });
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }
}
