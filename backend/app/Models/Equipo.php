<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'tipo',
        'marca',
        'modelo',
        'numero_serie',
        'estado',
        'descripcion',
        'fecha_adquisicion'
    ];

    protected $casts = [
        'fecha_adquisicion' => 'date'
    ];

    public function incidencias()
    {
        return $this->hasMany(Incidencia::class);
    }
} 