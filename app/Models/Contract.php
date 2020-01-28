<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    protected $fillable = [
        'date_begin',
        'date_end',
        'property_id',
        'tenant_id',
        'locator_id',
    ];
}
