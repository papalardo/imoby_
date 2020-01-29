<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Locator extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'first_name',
        'last_name',
        'cpf',
    ];
}
