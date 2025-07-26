<?php

namespace App\Models;

use Bootstrap\Column;
use Bootstrap\Model;
use Laravel\Sanctum\HasApiTokens;

class User extends Model
{
  use HasApiTokens;

  #[Column] public int $id;
  #[Column] public string $email;
  #[Column] public string $password;
  #[Column] public string $created_at;
  #[Column] public string $updated_at;

  protected $hidden = ['password'];
  protected $casts = ['password' => 'hashed'];

  static $rules = [
    'email' => ['required_without:id', 'email', 'unique:users,email'],
    'password' => ['required_without:id', 'min:8'],
  ];


  function comments()
  {
    return $this->hasMany(Comment::class);
  }

  function medications()
  {
    return $this->hasMany(Medication::class);
  }

  public function files()
  {
    return $this->hasMany(File::class);
  }
}
