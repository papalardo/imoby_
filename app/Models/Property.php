<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Property extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'address',
        'ceb_code',
    ];
}
