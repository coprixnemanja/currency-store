<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'signature',
        'rate',
        'surcharge',
        'send_order_email',
        'discount'
    ];

    protected $casts = [
        'send_order_email' => 'boolean',
    ];
}
