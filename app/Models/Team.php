<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;
    //many to many dengan pos
    public function pos() {
        return $this->belongsToMany("App\Models\Post", "points", "team_id", "post_id")->withPivot("point");
    }

    // buat ambil nama tim dari akun
    public function account()
    {
        return $this->belongsTo("App/Models/Account", "account_id", "id");
    }
}
