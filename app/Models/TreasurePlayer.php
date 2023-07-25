<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TreasurePlayer extends Model
{
    public $table = "treasure_players";
    use HasFactory;

    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}
