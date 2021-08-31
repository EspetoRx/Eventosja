<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Convidados;

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

    public function convidados()
    {
        return $this->belongsToMany(Convidados::class, 'convidado_evento', 'evento_id', 'convidado_id');
    }
}
