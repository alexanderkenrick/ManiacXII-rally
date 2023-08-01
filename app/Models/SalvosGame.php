<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalvosGame extends Model
{
    public $table = "salvos_games";
    use HasFactory;


    public function team() {
        return $this->belongsTo(Team::class);
    }
}
