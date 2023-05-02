<?php

namespace Database\Seeders;

use App\Models\Technology;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TechnologySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tecnologies_list = ['html', 'css', 'vue', 'bootstrap', 'tailwind', 'php', 'laravel', 'mysql'];

        foreach ($tecnologies_list as $technology_name) {

            $new_t = new Technology();

            $new_t->technology = $technology_name;

            $new_t->save();
        }
    }
}
