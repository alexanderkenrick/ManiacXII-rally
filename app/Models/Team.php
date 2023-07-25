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

    public function inventory() {
        return $this->hasMany(Inventory::class);
    }
    public function salvos_post() {
        return $this->hasMany(SalvosPost::class);
    }

    public function treasure_post() {
        return $this->hasMany(TreasurePost::class);
    }
}
