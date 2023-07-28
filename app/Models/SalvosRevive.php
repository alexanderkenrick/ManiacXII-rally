<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalvosRevive extends Model
{
    public $table = "salvos_revives";
    use HasFactory;

    public function salvosGame() {
        return $this->belongsTo(SalvosGame::class);
    }
}
