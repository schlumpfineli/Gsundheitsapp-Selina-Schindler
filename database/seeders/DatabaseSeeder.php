<?php

namespace Database\Seeders;

// faker: https://fakerphp.github.io/formatters/text-and-paragraphs/

use App\Models\Medication;
//use App\Models\Comment;
use App\Models\File;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  function run()
  {
    // users
    ////////////////////////////////////////////////////////////////////////////
    User::create([
      'email' => 'alpha@mailinator.com',
      'password' => 'password',
    ]);

    User::create([
      'email' => 'bravo@mailinator.com',
      'password' => 'password',
    ]);

    User::create([
      'email' => 'charlie@mailinator.com',
      'password' => 'password',
    ]);

    // medications
    ////////////////////////////////////////////////////////////////////////////

    for ($i = 0; $i < 20; $i++) {
      Medication::create([
        'name' => fake()->randomElement(['Ibuprofen', 'Paracetamol', 'Aspirin', 'Metformin', 'Insulin']),
        'dosage' => fake()->numberBetween(50, 1000) . fake()->randomElement(['mg', 'IU']),
        'time_of_day' => json_encode(
          fake()->randomElements(
            ['morning', 'midday', 'evening', 'night'],
            rand(1, 4)
          )
        ),
        'notes' => fake()->optional(0.7)->randomElement([
          'Nüchtern einnehmen',
          'Mit viel Wasser',
          'Nicht mit Alkohol kombinieren',
          null
        ]),
        'user_id' => User::inRandomOrder()->first()->id,
      ]);
    }
    // files
    ////////////////////////////////////////////////////////////////////////////
    for ($i = 0; $i < 20; $i++) {
      File::create([
        'name' => fake()->sentence(),
        'comment' => fake()->sentence(),
        'user_id' => random_int(1, 3),
      ]);
    }

    // comments
    ////////////////////////////////////////////////////////////////////////////
    //for ($i = 0; $i < 20; $i++) {
    //Comment::create([
    // 'text' => fake()->sentence(),
    //'article_id' => random_int(1, 10),
    //'user_id' => random_int(1, 3),
    //]);
    // }
  }
}
