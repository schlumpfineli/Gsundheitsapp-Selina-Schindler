<?php

namespace App\Models;

use Bootstrap\Column;
use Bootstrap\Model;
use Illuminate\Support\Facades\Storage;

class Upload extends Model
{
  #[Column] public int $id;
  #[Column] public int $user_id;
  #[Column] public string $file_path;
  #[Column] public string $original_name;
  #[Column] public string $display_name; // Benutzerdefinierter Name
  #[Column] public string $category;
  #[Column] public ?string $comment;
  #[Column] public string $mime_type;
  #[Column] public int $size;
  #[Column] public bool $is_public;
  #[Column] public string $created_at;
  #[Column] public string $updated_at;

  protected $casts = [
    'is_public' => 'boolean',
    'size' => 'integer'
  ];

  public static $rules = [
    'file' => 'required|file|max:5000', // 5MB
    'display_name' => 'required|string|max:100',
    'category' => 'required|in:doctor,neurology,psychology,therapy,alternative,other',
    'comment' => 'nullable|string|max:500',
    'is_public' => 'boolean'
  ];
}
