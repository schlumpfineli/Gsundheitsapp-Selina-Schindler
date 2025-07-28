<?php

namespace App\Controllers;

use Bootstrap\Column;
use Bootstrap\Model;

class File extends Model
{
  #[Column] public int $id;
  #[Column] public string $name;
  #[Column] public string $path;
  #[Column] public string $mime_type;
  #[Column] public int $size;
  #[Column] public string $comment;
  #[Column] public int $user_id;
  #[Column] public string $created_at;
  #[Column] public string $updated_at;

  static $rules = [
    'name' => ['required_without:id', 'min:1', 'max:255'],
    'comment' => ['sometimes', 'max:500'],
    // Datei wird separat validiert
  ];
}
