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
        'property_owner_id',
        'tenant_id',
        'price'
    ];

    protected $dates = [
        'date_begin',
        'date_end',
    ];

    public function propertyOwner() 
    {
        return $this->belongsTo(PropertyOwner::class);
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
        return $this->hasMany(Finance::class)->where('type', Finance::RENTAL_PAYMENTS);
    }

    public function rentalPayment() {
        return $this->hasOne(Finance::class)->where('type', Finance::RENTAL_PAYMENTS);
    }
}
