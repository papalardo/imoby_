<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RentalPayment extends Model
{
    protected $fillable = [
        'month_ref',
        'year_ref',
        'paid'
    ];
    
    public function contract() {
        return $this->belongsTo(Contract::class);
    }
}
