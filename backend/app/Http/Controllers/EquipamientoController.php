<?php

namespace App\Http\Controllers;

use App\Models\Equipamiento;
use Illuminate\Http\Request;

class EquipamientoController extends Controller
{
    public function index()
    {
        return response()->json(Equipamiento::with('ubicacion')->get());
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'modelo' => 'required|string|max:100',
            'numero_serie' => 'required|string|max:50|unique:equipamiento',
            'ubicacion_id' => 'nullable|exists:ubicaciones,id',
            'estado' => 'required|string|in:operativo,averiado,reparacion,retirado'
        ]);

        $equipamiento = Equipamiento::create($request->all());
        return response()->json($equipamiento, 201);
    }

    public function show(Equipamiento $equipamiento)
    {
        return response()->json($equipamiento->load('ubicacion'));
    }

    public function update(Request $request, Equipamiento $equipamiento)
    {
        $request->validate([
            'nombre' => 'string|max:100',
            'descripcion' => 'nullable|string',
            'modelo' => 'string|max:100',
            'numero_serie' => 'string|max:50|unique:equipamiento,numero_serie,' . $equipamiento->id,
            'ubicacion_id' => 'nullable|exists:ubicaciones,id',
            'estado' => 'string|in:operativo,averiado,reparacion,retirado'
        ]);

        $equipamiento->update($request->all());
        return response()->json($equipamiento);
    }

    public function destroy(Equipamiento $equipamiento)
    {
        $equipamiento->delete();
        return response()->json(null, 204);
    }
} 