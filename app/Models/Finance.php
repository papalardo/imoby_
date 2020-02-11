<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Finance extends Model
{
    CONST RENTAL_PAYMENTS = 'rental_payments';

    CONST COMMISSION = 'commission';
    
    protected $fillable = [
        'contract_id',
        'property_owner_id',
        'month_ref',
        'year_ref',
        'type',
        'debt',
        'credit',
    ];

    protected $casts = [
        'debt' => 'double',
        'credit' => 'double',
    ];
}
