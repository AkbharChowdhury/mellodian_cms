<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;

    protected $dates = [
        'created_at',
        'updated_at',
        'event_date'
        // your other new column
    ];
}
