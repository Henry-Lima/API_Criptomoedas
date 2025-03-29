<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiCripto extends Model
{
    protected $fillable = [
        'sigla',
        'nome',
        'valor',
    ];  

}
