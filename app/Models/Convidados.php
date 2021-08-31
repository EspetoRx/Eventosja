<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Eventos;

class Convidados extends Model
{
    use HasFactory;

    protected $fillable =
    [
        'id',
        'nome',
        'email',
        'created_at',
        'updated_at',
    ];

    public function eventos()
    {
        return $this->belongsToMany(Eventos::class, 'convidados_eventos', 'convidado_id', 'evento_id')->withPivot('id');
    }
}
