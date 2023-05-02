<?php

namespace Database\Seeders;

use App\Models\Type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $types_arr = ['contribution', 'personal-project', 'client-project'];

        foreach ($types_arr as $type) {
            $new_t = new Type();

            $new_t->type = $type;

            $new_t->save();
        }
    }
}
