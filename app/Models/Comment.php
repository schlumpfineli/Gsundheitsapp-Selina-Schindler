<?php

namespace App\Models;

use Bootstrap\Column;
use Bootstrap\Model;

class Comment extends Model
{
  #[Column] public int $id;
  #[Column] public string $text;
  #[Column] public int $article_id;
  #[Column] public int $user_id;
  #[Column] public string $created_at;
  #[Column] public string $updated_at;

  static $rules = [
    'text' => ['required_without:id', 'min:1', 'max: 200'],
    'article_id' => ['required_without:id', 'exists:articles,id'],
  ];
}
