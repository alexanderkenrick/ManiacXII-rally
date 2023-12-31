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

    protected $fillable = [
        'currency'
    ];

    // buat ambil nama tim dari akun
    public function account()
    {
        return $this->belongsTo("App\Models\Account", "account_id", "id");
    }

    public function item(){
        return $this->belongsToMany("App\Models\Item","inventories","teams_id","items_id")->withPivot("count");
    }

    // public function inventory() {
    //     return $this->hasMany(Inventory::class);
    // }
    public function salvos_post() {
        return $this->hasMany(SalvosPost::class);
    }

    public function salvos_games() {
        return $this->hasMany("\App\Models\SalvosGame", "teams_id", "id");
    }

    public function treasure_post() {
        return $this->hasMany(TreasurePost::class);
    }
}
