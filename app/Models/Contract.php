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
        'tenant_id',
        'locator_id',
    ];
}
