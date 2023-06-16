<?php

namespace App\Models;

use App\Enums\Tickets;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;
    protected $casts = [
        'tickets' => Tickets::class
    ];
}
