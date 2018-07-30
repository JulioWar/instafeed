<?php
namespace App\Models;

class Post extends Model {
  protected $table = "posts";

  public function user() {
    return $this->belongsTo(User::class,'user_id');
  }

  public function likes() {
    return $this->belongsToMany(User::class,'likes','post_id','user_id');
  }
}
