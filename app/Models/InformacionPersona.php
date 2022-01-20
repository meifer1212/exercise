<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InformacionPersona extends Model
{
    use HasFactory;

    protected $table = 'informacion_personas';
    protected $fillable = [
        'nombre',
        'datos_activo',
        'tipo_persona',
        'tipo_cargo',
        'departamento',
        'municipio',
        'localidad',
    ];
}
