<?php

namespace Database\Seeders;

// faker: https://fakerphp.github.io/formatters/text-and-paragraphs/

use App\Models\Medication;
use App\Models\Comment;
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
        'dosage' => fake()->randomElement(['200mg', '500mg', '1g', '50IU']),
        'administration_form' => fake()->randomElement(['tablet', 'capsule', 'injection', 'syrup', 'patch']),
        'time_of_day' => json_encode(
          fake()->randomElements(
            ['morning', 'noon', 'evening', 'night'],
            rand(1, 3) // 1-3 Einnahmezeiten
          )
        ),
        'notes' => fake()->optional()->sentence(),
        'user_id' => User::inRandomOrder()->first()->id, // Zufälliger User
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
