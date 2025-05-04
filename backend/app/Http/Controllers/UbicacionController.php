<?php

namespace App\Http\Controllers;

use App\Models\Ubicacion;
use Illuminate\Http\Request;

class UbicacionController extends Controller
{
    public function index()
    {
        return response()->json(Ubicacion::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'estado' => 'required|string|in:activo,inactivo'
        ]);

        $ubicacion = Ubicacion::create($request->all());
        return response()->json($ubicacion, 201);
    }

    public function show(Ubicacion $ubicacion)
    {
        return response()->json($ubicacion);
    }

    public function update(Request $request, Ubicacion $ubicacion)
    {
        $request->validate([
            'nombre' => 'string|max:100',
            'descripcion' => 'nullable|string',
            'estado' => 'string|in:activo,inactivo'
        ]);

        $ubicacion->update($request->all());
        return response()->json($ubicacion);
    }

    public function destroy(Ubicacion $ubicacion)
    {
        $ubicacion->delete();
        return response()->json(null, 204);
    }
} 