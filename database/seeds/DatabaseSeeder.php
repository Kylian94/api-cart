<?php

use Illuminate\Database\Seeder;
use phpDocumentor\Reflection\Types\Float_;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        for ($i = 0; $i < 10; $i++) {
            DB::table('products')->insert([
                'name' => $faker->name,
                'price' => rand(0, 100) / 10,
                'description' => $faker->realText($maxNbChars = 200, $indexSize = 2),
            ]);
        }
    }
}
