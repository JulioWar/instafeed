<?php
namespace App\Models;

class User extends Model {
  protected $table = "users";

  public function posts() {
      return $this->hasMany(Post::class, 'user_id');
  }

  public function followers() {
    return $this->belongsToMany(User::class,'followers','author_id','follower_id');
  }

}
