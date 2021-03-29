<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Faker;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $categories = [];

        for ($i = 0; $i < 5; $i++) {
            $categories[] = new Category();
        }

        for ($i = 0; $i < 5; $i++) {
            $categories[$i]->name = $faker->word();
            $categories[$i]->save();
        }
    }
}
