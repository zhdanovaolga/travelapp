<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscribedUser extends Model
{

    protected $fillable = [
        'id',
        'user_id',
        'favorite_user_id',
    ];

    public $timestamps = false;
    
    protected function username(): Attribute {
        return Attribute::make(
            set: fn ($value) => Str::lower($value)
        );
    }

}