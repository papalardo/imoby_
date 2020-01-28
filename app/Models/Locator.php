<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Locator extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'cpf',
    ];
}
