<?php

namespace App\Controllers;

use Bootstrap\Column;
use Bootstrap\Model;

class Medication extends Model
{
  #[Column] public int $id;
  #[Column] public string $name;
  #[Column] public string $dosage;
  #[Column] public string $frequency;
  #[Column] public string $notes;
  #[Column] public int $user_id;
  #[Column] public string $created_at;
  #[Column] public string $updated_at;

  static $rules = [
    'name' => ['required_without:id', 'min:2', 'max:100'],
    'dosage' => ['sometimes', 'max:5000'],
    'frequency' => ['sometimes', 'max:4'],
    'notes' => ['sometimes', 'max:500'],
  ];
}
