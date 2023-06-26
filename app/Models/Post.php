<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $table = 'posts';

    //many to many dengan player
    public function teams() {
        return $this->belongsToMany("App\Models\Team", "points", "post_id", "team_id")->withPivot("point");
    }
}
