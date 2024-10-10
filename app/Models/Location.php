<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Location extends Model
{
    use HasFactory;

    protected $table = "locations";
    protected $fillable = [
        "event_id",
        "file_name",
        "description",
        
    ];

    public function event() {
        return $this->belongsTo(Event::class);
    }

   


}
