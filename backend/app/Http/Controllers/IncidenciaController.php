<?php

namespace App\Http\Controllers;

use App\Models\Incidencia;
use App\Models\LogIncidencia;
use Illuminate\Http\Request;

class IncidenciaController extends Controller
{
    public function index(Request $request)
    {
        $query = Incidencia::with(['usuario', 'equipamiento', 'ubicacion']);

        // Filtrado por estado
        if ($request->has('estado')) {
            $query->where('estado', $request->estado);
        }

        // Filtrado por prioridad
        if ($request->has('prioridad')) {
            $query->where('prioridad', $request->prioridad);
        }

        // Filtrado por equipo
        if ($request->has('equipamiento_id')) {
            $query->where('equipamiento_id', $request->equipamiento_id);
        }

        // Filtrado por ubicación
        if ($request->has('ubicacion_id')) {
            $query->where('ubicacion_id', $request->ubicacion_id);
        }

        // Filtrado por usuario
        if ($request->has('usuario_id')) {
            $query->where('usuario_id', $request->usuario_id);
        }

        // Filtrado por privacidad
        if ($request->has('es_privada')) {
            $query->where('es_privada', $request->es_privada);
        }

        // Búsqueda por título o descripción
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('titulo', 'like', "%{$search}%")
                  ->orWhere('descripcion', 'like', "%{$search}%");
            });
        }

        return response()->json($query->get());
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:200',
            'descripcion' => 'required|string',
            'prioridad' => 'required|string|in:baja,media,alta,urgente',
            'estado' => 'required|string|in:pendiente,en_proceso,resuelta,cerrada',
            'es_privada' => 'boolean',
            'usuario_id' => 'nullable|exists:usuarios,id',
            'equipamiento_id' => 'nullable|exists:equipamiento,id',
            'ubicacion_id' => 'nullable|exists:ubicaciones,id'
        ]);

        $incidencia = Incidencia::create($request->all());

        // Crear log de la incidencia
        if ($request->has('usuario_id')) {
            LogIncidencia::create([
                'incidencia_id' => $incidencia->id,
                'usuario_id' => $request->usuario_id,
                'accion' => 'creacion'
            ]);
        }

        return response()->json($incidencia, 201);
    }

    public function show(Incidencia $incidencia)
    {
        return response()->json($incidencia->load(['usuario', 'equipamiento', 'ubicacion', 'logs']));
    }

    public function update(Request $request, Incidencia $incidencia)
    {
        $request->validate([
            'titulo' => 'string|max:200',
            'descripcion' => 'string',
            'prioridad' => 'string|in:baja,media,alta,urgente',
            'estado' => 'string|in:pendiente,en_proceso,resuelta,cerrada',
            'es_privada' => 'boolean',
            'usuario_id' => 'nullable|exists:usuarios,id',
            'equipamiento_id' => 'nullable|exists:equipamiento,id',
            'ubicacion_id' => 'nullable|exists:ubicaciones,id'
        ]);

        $incidencia->update($request->all());

        // Crear log de la actualización
        if ($request->has('usuario_id')) {
            LogIncidencia::create([
                'incidencia_id' => $incidencia->id,
                'usuario_id' => $request->usuario_id,
                'accion' => 'actualizacion'
            ]);
        }

        return response()->json($incidencia);
    }

    public function destroy(Incidencia $incidencia)
    {
        $incidencia->delete();
        return response()->json(null, 204);
    }

    // Nuevos endpoints
    public function getByEquipamiento($equipamientoId)
    {
        $incidencias = Incidencia::where('equipamiento_id', $equipamientoId)
            ->with(['usuario', 'equipamiento', 'ubicacion'])
            ->get();
            
        return response()->json($incidencias);
    }

    public function getByUbicacion($ubicacionId)
    {
        $incidencias = Incidencia::where('ubicacion_id', $ubicacionId)
            ->with(['usuario', 'equipamiento', 'ubicacion'])
            ->get();
            
        return response()->json($incidencias);
    }

    public function getByUsuario($usuarioId)
    {
        $incidencias = Incidencia::where('usuario_id', $usuarioId)
            ->with(['usuario', 'equipamiento', 'ubicacion'])
            ->get();
            
        return response()->json($incidencias);
    }

    public function getLogs(Incidencia $incidencia)
    {
        return response()->json($incidencia->logs()->with('usuario')->get());
    }

    public function updateEstado(Request $request, Incidencia $incidencia)
    {
        $request->validate([
            'estado' => 'required|string|in:pendiente,en_proceso,resuelta,cerrada',
            'usuario_id' => 'required|exists:usuarios,id'
        ]);

        $incidencia->update(['estado' => $request->estado]);

        LogIncidencia::create([
            'incidencia_id' => $incidencia->id,
            'usuario_id' => $request->usuario_id,
            'accion' => 'cambio_estado'
        ]);

        return response()->json($incidencia);
    }
} 