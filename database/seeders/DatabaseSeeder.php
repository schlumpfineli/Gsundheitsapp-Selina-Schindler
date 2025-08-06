<?php

namespace Database\Seeders;

// faker: https://fakerphp.github.io/formatters/text-and-paragraphs/

use App\Models\Medication;
//use App\Models\Comment;
use App\Models\Upload;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
  function run()
  {
    // users
    ////////////////////////////////////////////////////////////////////////////
    $users = [
      User::create([
        'email' => 'alpha@mailinator.com',
        'password' => 'password',
      ]),
      User::create([
        'email' => 'bravo@mailinator.com',
        'password' => 'password',
      ]),
      User::create([
        'email' => 'charlie@mailinator.com',
        'password' => 'password',
      ])
    ];

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

    // uploads
    ////////////////////////////////////////////////////////////////////////////
    $categories = ['doctor', 'neurology', 'psychology', 'therapy', 'alternative', 'other'];
    $fileTypes = [
      'pdf' => ['Blutwerte.pdf', 'Rezept.pdf', 'Bericht.pdf'],
      'jpg' => ['Röntgen.jpg', 'Ultraschall.jpg'],
      'docx' => ['Therapieplan.docx']
    ];

    foreach ($users as $user) {
      foreach ($categories as $category) {
        foreach ($fileTypes as $type => $files) {
          foreach ($files as $file) {
            $path = "uploads/{$user->id}/{$file}";

            Storage::disk('public')->put($path, 'Seed content: ' . $file);

            Upload::create([
              'user_id' => $user->id,
              'file_path' => $path,
              'original_name' => $file,
              'display_name' => pathinfo($file, PATHINFO_FILENAME),
              'category' => $category,
              'comment' => $this->generateComment($category),
              'mime_type' => $this->getMimeType($file),
              'size' => rand(100000, 5000000),
              'is_public' => rand(0, 1)
            ]);
          }
        }
      }
    }
  }

  private function generateComment(string $category): ?string
  {
    return match ($category) {
      'doctor' => 'Befund vom ' . now()->format('d.m.Y'),
      'therapy' => 'Sitzung #' . rand(1, 10),
      default => fake()->optional()->sentence()
    };
  }

  private function getMimeType(string $filename): string
  {
    return match (pathinfo($filename, PATHINFO_EXTENSION)) {
      'pdf' => 'application/pdf',
      'jpg' => 'image/jpeg',
      'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
      default => 'application/octet-stream'
    };
  }
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
