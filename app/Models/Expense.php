<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Expense extends Model
{
    protected $table = "expenses";
    protected $fillable = [
        "event_id",
        "description",
        "cost",
    ];

    public function event() {
        return $this->belongsTo(Event::class);
    }

}