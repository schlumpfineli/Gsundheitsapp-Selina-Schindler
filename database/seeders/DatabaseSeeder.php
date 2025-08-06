<?php

namespace Database\Seeders;

use App\Models\Medication;
use App\Models\Upload;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
  /**
   * Get the mime type based on file extension.
   */
  private function getMimeType($extension)
  {
    $mimeTypes = [
      'pdf' => 'application/pdf',
      'jpg' => 'image/jpeg',
      'jpeg' => 'image/jpeg',
      'png' => 'image/png',
      'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    ];
    return $mimeTypes[$extension] ?? 'application/octet-stream';
  }

  public function run()
  {
    // users
    ////////////////////////////////////////////////////////////////////////////
    User::create([
      'email' => 'alpha@mailinator.com',
      'password' => 'password',
      'is_admin' => true,
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

    // uploads
    ////////////////////////////////////////////////////////////////////////////
    for ($i = 0; $i < 20; $i++) {
      $user = User::inRandomOrder()->first();
      $fileType = fake()->randomElement(['pdf', 'jpg', 'docx']);
      $fileName = fake()->word() . '.' . $fileType;
      $path = "uploads/{$user->id}/{$fileName}";

      Storage::disk('public')->put($path, 'Seed content: ' . $fileName);

      Upload::create([
        'user_id' => $user->id,
        'file_path' => $path,
        'original_name' => $fileName,
        'display_name' => fake()->words(2, true),
        'category' => fake()->randomElement(['doctor', 'neurology', 'psychology', 'therapy', 'alternative', 'other']),
        'comment' => fake()->optional(0.7)->sentence(),
        'mime_type' => $this->getMimeType($fileType),
        'size' => fake()->numberBetween(100000, 5000000),
        'is_public' => fake()->boolean(30)
      ]);
    }
  }
}
