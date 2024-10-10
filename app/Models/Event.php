<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Event extends Model
{
    protected $table = "events";

    protected $fillable = [
        "type",
        "journey_id",
        "event_date",
    ];
    
    protected $casts = [
        'event_date' => 'datetime:d.m.Y H:i',
    ];   

    public function location() {
        return $this->hasOne(Location::class);
    }

    public function place() {
        return $this->hasOne(Place::class);
    }

    public function expense() {
        return $this->hasOne(Expense::class);
    }

    public function journey() {
        return $this->belongsTo(Journey::class);
    }

    protected function casts(): array
    {
        return [
            'event_date' => 'datetime:d.m.Y H:i',
        ];
    }   

}