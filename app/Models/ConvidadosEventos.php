<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Convidados;
use App\Models\Eventos;

class ConvidadosEventos extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'evento_id',
        'convidado_id',
        'created_at',
        'updated_at',
    ];

    public function convidado(){
        return $this->belongsTo(Convidados::class, 'convidado_id')->with(['eventos']);
    }

    public function evento(){
        return $this->belongsTo(Eventos::class, 'evento_id')->with(['convidados']);
    }
}
