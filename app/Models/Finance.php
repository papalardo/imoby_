<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Finance extends Model
{
    CONST RENTAL_PAYMENTS = 'rental_payments';
    
    protected $fillable = [
        'contract_id',
        'month_ref',
        'year_ref',
        'type',
        'debt',
        'credit',
    ];
}
