<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;
    //many to many dengan pos
    public function point() {
        return $this->hasMany(Point::class);
    }

    // buat ambil nama tim dari akun
    public function account()
    {
        return $this->belongsTo("App\Models\Account", "account_id", "id");
    }
}
