<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurrencyOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'currency_id',
        'rate',
        'surcharge_percentage',
        'surcharge_amount',
        'amount_purchased',
        'amount_usd',
        'discount_percentage',
        'discount_amount'
    ];


    public function currency(){
        return $this->belongsTo(Currency::class);
    }
}
