<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ubicacion extends Model
{
    use HasFactory;

    protected $table = 'ubicaciones';

    protected $fillable = [
        'nombre',
        'descripcion',
        'estado'
    ];

    public function equipamiento()
    {
        return $this->hasMany(Equipamiento::class);
    }

    public function incidencias()
    {
        return $this->hasMany(Incidencia::class);
    }
} 