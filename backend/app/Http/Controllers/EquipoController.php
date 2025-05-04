<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use Illuminate\Http\Request;

class EquipoController extends Controller
{
    public function index()
    {
        return response()->json(Equipo::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string',
            'tipo' => 'required|string',
            'marca' => 'required|string',
            'modelo' => 'required|string',
            'numero_serie' => 'required|string|unique:equipos',
            'estado' => 'required|string',
            'descripcion' => 'nullable|string',
            'fecha_adquisicion' => 'required|date'
        ]);

        $equipo = Equipo::create($request->all());
        return response()->json($equipo, 201);
    }

    public function show(Equipo $equipo)
    {
        return response()->json($equipo);
    }

    public function update(Request $request, Equipo $equipo)
    {
        $request->validate([
            'nombre' => 'string',
            'tipo' => 'string',
            'marca' => 'string',
            'modelo' => 'string',
            'numero_serie' => 'string|unique:equipos,numero_serie,' . $equipo->id,
            'estado' => 'string',
            'descripcion' => 'nullable|string',
            'fecha_adquisicion' => 'date'
        ]);

        $equipo->update($request->all());
        return response()->json($equipo);
    }

    public function destroy(Equipo $equipo)
    {
        $equipo->delete();
        return response()->json(null, 204);
    }
} 