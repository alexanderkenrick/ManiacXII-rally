<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;
    //many to many dengan pos
    public function pos() {
        return $this->belongsToMany("App\Post", "point", "team_id", "post_id")->withPivot("points");
    }
}
