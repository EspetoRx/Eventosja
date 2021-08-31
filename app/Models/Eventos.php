<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eventos extends Model
{
    use HasFactory;

    protected $fillable = 
    [
        'id',
        'descricao',
        'data_evento',
        'created_at',
        'updated_at'
    ];
}
