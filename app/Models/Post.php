<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $table = 'posts';

    //many to many dengan player
    public function point() {
        return $this->hasMany(Point::class);
    }

    public function account()
    {
        return $this->belongsTo('App\Models\Account', 'account_id', 'id');
    }
}
