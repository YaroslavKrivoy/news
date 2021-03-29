<?php

namespace Database\Seeders;

use App\Models\News;
use Illuminate\Database\Seeder;
use Faker;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $news = [];

        for ($i = 0; $i < 5; $i++) {
            $news[] = new News();
        }

        for ($i = 0; $i < 5; $i++) {
            $news[$i]->title = $faker->word();
            $news[$i]->short_description = $faker->text(30);
            $news[$i]->description = $faker->text(200);
            $news[$i]->isVisible = $faker->boolean();
            $news[$i]->image_url = $faker->imageUrl($width = 640, $height = 480);
            $news[$i]->user_id = $faker->numberBetween(1,2);
            $news[$i]->category_id = $faker->numberBetween(1,5);
            $news[$i]->save();
        }
    }
}
