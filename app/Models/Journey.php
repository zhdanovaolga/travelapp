<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Journey extends Model
{
    use HasFactory;

    protected $table = "journies";
    protected $fillable = [
        "user_id",
        "description",
        "thumbnail",
        "views",
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'enable_comment' => 'boolean',
        'status' => 'boolean',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function events() {
        return $this->hasMany(User::class);
    }

    public function readTime() {
        $minutesToRead = round(Str::wordCount(static::find($this->id)->content) / 200);
        if ($minutesToRead < 1) {
            return "Less than a minute";
        }
        return $minutesToRead." Mins Read";
    }


}
