<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Account extends Model implements Authenticatable
{
    use HasFactory;
    protected $fillable = [
        'username', 'password', 'role', 'name'
    ];

    protected $hidden = [
        'password',
    ];
    // Relasi 1-1
    public function team()
    {
        return $this->hasOne('App\Models\Team', 'account_id', 'id');
    }
    // Relasi 1-1
    public function post()
    {
        return $this->hasOne('App\Models\Post', 'penpos_id', 'id');
    }

    public function getAuthIdentifier()
    {
        return $this->getKey();
    }

    public function getAuthIdentifierName()
    {
        return 'id';
    }
    public function getRememberTokenName()
    {
        return 'remember_token';
    }

    public function getRememberToken()
    {
        return $this->{$this->getRememberTokenName()};
    }

    public function setRememberToken($value)
    {
        $this->{$this->getRememberTokenName()} = $value;
    }

    public function getAuthPassword()
    {
        return $this->password;
    }
}
