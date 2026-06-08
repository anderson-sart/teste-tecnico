<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index()
    {
        return response()->json(Cliente::orderBy('codigo', 'desc')->get());
    }

    public function show($id)
    {
        $cliente = Cliente::find($id);
        if (!$cliente) {
            return response()->json(['error' => 'Cliente não encontrado'], 404);
        }
        return response()->json($cliente);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|max:60',
            'fantasia' => 'nullable|max:100',
            'documento' => 'required|max:18',
            'endereco' => 'nullable'
        ]);

        $cliente = Cliente::create($validated);
        return response()->json($cliente, 201);
    }

    public function update(Request $request, $id)
    {
        $cliente = Cliente::find($id);
        if (!$cliente) {
            return response()->json(['error' => 'Cliente não encontrado'], 404);
        }

        $validated = $request->validate([
            'nome' => 'required|max:60',
            'fantasia' => 'nullable|max:100',
            'documento' => 'required|max:18',
            'endereco' => 'nullable'
        ]);

        $cliente->update($validated);
        return response()->json($cliente);
    }

    public function destroy($id)
    {
        $cliente = Cliente::find($id);
        if (!$cliente) {
            return response()->json(['error' => 'Cliente não encontrado'], 404);
        }

        $cliente->delete();
        return response()->json(['message' => 'Cliente deletado com sucesso']);
    }
}
