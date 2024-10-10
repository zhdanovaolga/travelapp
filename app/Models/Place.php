<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    use HasFactory;

    protected $table = "places";

    protected $fillable = [
        "event_id",
        "title",
        "file_name",
        "description",
        
    ];

    public function event() {
        return $this->belongsTo(Event::class);
    }

}
