<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipamiento extends Model
{
    use HasFactory;

    protected $table = 'equipamiento';

    protected $fillable = [
        'nombre',
        'descripcion',
        'modelo',
        'numero_serie',
        'ubicacion_id',
        'estado'
    ];

    public function ubicacion()
    {
        return $this->belongsTo(Ubicacion::class);
    }

    public function incidencias()
    {
        return $this->hasMany(Incidencia::class);
    }
} 