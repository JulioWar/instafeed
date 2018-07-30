<?php
namespace App\Models;

class Follower extends Model {
  protected $table = "followers";

  public function author() {
    return $this->belongsTo(User::class, 'author_id');
  }

  public function follower() {
    return $this->belongsTo(User::class, 'follower_id');
  }
}
