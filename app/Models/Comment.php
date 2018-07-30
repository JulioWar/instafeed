<?php
namespace App\Models;

class Comment extends Model {
  protected $table = "comments";

  public function user() {
    return $this->belongsTo(User::class, 'user_id')
  }
}
