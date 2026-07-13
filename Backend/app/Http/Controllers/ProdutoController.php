<?php

class ProdutoController extends Controller {
    
    public function index() {
        return Produto::paginate([
            'search' => Request::query('search', ''),
            'sort_by' => Request::query('sort_by', 'codigo'),
            'sort_dir' => Request::query('sort_dir', 'DESC'),
            'page' => Request::query('page', 1),
            'per_page' => Request::query('per_page', 10),
        ]);
    }
    
    public function show($id) {
        return $this->validateExists(Produto::class, $id, 'Produto não encontrado');
    }
    
    public function store() {
        Validator::validate(Request::all(), [
            'descricao' => 'required|max:60',
            'codigo_barras' => 'barcode',
            'valor_venda' => 'required|numeric|max:99999999.99',
            'peso_bruto' => 'required|numeric|max:9999999.999',
            'peso_liquido' => 'required|numeric|max:9999999.999'
        ]);
        
        return $this->success(Produto::create(Request::all()), 'Produto criado com sucesso');
    }
    
    public function update($id) {
        $this->validateExists(Produto::class, $id, 'Produto não encontrado');
        
        Validator::validate(Request::all(), [
            'descricao' => 'required|max:60',
            'codigo_barras' => 'barcode',
            'valor_venda' => 'required|numeric|max:99999999.99',
            'peso_bruto' => 'required|numeric|max:9999999.999',
            'peso_liquido' => 'required|numeric|max:9999999.999'
        ]);
        
        return $this->success(Produto::update($id, Request::all()), 'Produto atualizado com sucesso');
    }
    
    public function destroy($id) {
        $this->validateExists(Produto::class, $id, 'Produto não encontrado');
        return $this->success(Produto::delete($id), 'Produto excluído com sucesso');
    }
}
