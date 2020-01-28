<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'cpf',
        'rg',
        'rg_agency_emissor',
        'rg_agency_state',
    ];
}
