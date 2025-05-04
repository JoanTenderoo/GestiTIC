<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incidencia extends Model
{
    use HasFactory;

    protected $table = 'incidencias';

    protected $fillable = [
        'titulo',
        'descripcion',
        'prioridad',
        'estado',
        'es_privada',
        'usuario_id',
        'equipamiento_id',
        'ubicacion_id'
    ];

    protected $casts = [
        'es_privada' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }

    public function equipamiento()
    {
        return $this->belongsTo(Equipamiento::class);
    }

    public function ubicacion()
    {
        return $this->belongsTo(Ubicacion::class);
    }

    public function logs()
    {
        return $this->hasMany(LogIncidencia::class);
    }
} 