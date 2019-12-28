<?php

use App\Bookable;
use Illuminate\Database\Seeder;
use App\Review;

class ReviewTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Bookable::all()->each(function (Bookable $bookable) {
            $reviews = factory(Review::class, random_int(5, 20))->make();
            $bookable->reviews()->saveMany($reviews);
        });
    }
}
