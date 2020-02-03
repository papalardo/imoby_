<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Contract extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'date_begin',
        'date_end',
        'property_id',
        'locator_id',
        'tenant_id',
    ];

    protected $dates = [
        'date_begin',
        'date_end',
    ];

    public function locator() 
    {
        return $this->belongsTo(Locator::class);
    }

    public function tenant() 
    {
        return $this->belongsTo(Tenant::class);
    }
    
    public function property() 
    {
        return $this->belongsTo(Property::class);
    }

    public function rentalPayments() {
        return $this->hasMany(RentalPayment::class);
    }
}
