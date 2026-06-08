<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index()
    {
        return response()->json(Cliente::orderBy('Codigo', 'desc')->get());
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
            'Nome' => 'required|max:60',
            'Fantasia' => 'nullable|max:100',
            'Documento' => 'required|max:18',
            'Endereco' => 'nullable'
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
            'Nome' => 'required|max:60',
            'Fantasia' => 'nullable|max:100',
            'Documento' => 'required|max:18',
            'Endereco' => 'nullable'
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
