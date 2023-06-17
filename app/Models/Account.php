<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;
    protected $fillable = [
        'username', 'password',
    ];

    protected $hidden = [
        'password',
    ];
    // Relasi 1-1
    public function team()
    {
        return $this->hasOne('App\Team', 'account_id', 'id');
    }
    // Relasi 1-1
    public function post()
    {
        return $this->hasOne('App\Post', 'penpos_id', 'id');
    }
}
