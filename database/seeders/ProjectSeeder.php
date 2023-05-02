<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Technology;
use App\Models\Type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {

        $type_ids = Type::all()->pluck('id');
        $technology_ids = Technology::all()->pluck('id')->all();

        for ($i = 0; $i < 10; $i++) {

            $proj = new Project();

            $proj->title = $faker->unique()->sentence($faker->numberBetween(3, 10));
            $proj->slug = Str::of($proj->title)->slug('-');
            $proj->description = $faker->sentence($faker->numberBetween(20, 100));
            $proj->website_link = 'https://it.wikipedia.org/wiki/Pagina_principale';
            $proj->source_code_link = 'https://github.com/';
            $proj->proj_category = $faker->randomElement([
                'frontend', 'backend', 'fullstack'
            ]);
            $proj->client = $faker->word();
            $proj->client_category = $faker->randomElement([
                'food-and-beverage', 'fashion', 'tech'
            ]);

            $proj->type_id = $faker->optional()->randomElement($type_ids);

            $proj->save();

            $proj->technologies()->attach($faker->randomElements($technology_ids, rand(0, 3)));
        }
    }
}
