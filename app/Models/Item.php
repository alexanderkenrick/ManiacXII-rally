<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    // public function inventory() {
    //     return $this->hasMany(Inventory::class);
    // }

    public function team(){
        return $this->belongsToMany("App\Models\Team","inventories","items_id","teams_id")->withPivot("count");
    }
}
