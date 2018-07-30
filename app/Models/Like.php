<?php
namespace App\Models;

class Like extends Model {
  protected $table = "likes";

  public function post() {
    return $this->belongsTo(Post::class, 'post_id');
  }

  public function user() {
    return $this->belongsTo(User::class, 'user_id');
  }
}
