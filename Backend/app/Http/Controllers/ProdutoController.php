<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    public function index()
    {
        return response()->json(Produto::orderBy('Codigo', 'desc')->get());
    }

    public function show($id)
    {
        $produto = Produto::find($id);
        if (!$produto) {
            return response()->json(['error' => 'Produto não encontrado'], 404);
        }
        return response()->json($produto);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'Descricao' => 'required|max:60',
            'CodigoBarras' => 'nullable|max:14',
            'ValorVenda' => 'required|numeric',
            'PesoBruto' => 'required|numeric',
            'PesoLiquido' => 'required|numeric'
        ]);

        $produto = Produto::create($validated);
        return response()->json($produto, 201);
    }

    public function update(Request $request, $id)
    {
        $produto = Produto::find($id);
        if (!$produto) {
            return response()->json(['error' => 'Produto não encontrado'], 404);
        }

        $validated = $request->validate([
            'Descricao' => 'required|max:60',
            'CodigoBarras' => 'nullable|max:14',
            'ValorVenda' => 'required|numeric',
            'PesoBruto' => 'required|numeric',
            'PesoLiquido' => 'required|numeric'
        ]);

        $produto->update($validated);
        return response()->json($produto);
    }

    public function destroy($id)
    {
        $produto = Produto::find($id);
        if (!$produto) {
            return response()->json(['error' => 'Produto não encontrado'], 404);
        }

        $produto->delete();
        return response()->json(['message' => 'Produto deletado com sucesso']);
    }
}
