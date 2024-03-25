<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;
use App\Models\Categoria;
use App\Http\Requests\ProdutoRequest;
use App\Http\Resources\ProdutoResource;

class ProdutoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $produtos = Produto::all();
        return response()->json(['message'=>'sucesso', 'produtos' => ProdutoResource::collection($produtos)], 202);
        // return ProdutoResource::collection($produtos);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(ProdutoRequest $request)
    {
        // $produto = Produto::create($request->validated());
        $produto = $request->validated();
        $produto['preco'] = floatval(str_replace(",", ".", preg_replace("/[^0-9.,]/", "", $produto['preco'])));
        $produto = Produto::create($produto);

        if ($request->has('categoria_id')){
            foreach ($request->input('categoria_id') as $categoria_id) {
                $produto->categorias()->attach($categoria_id);                
            }
        }

        return response()->json(['message'=>'inserido com sucesso', 'produto' => new ProdutoResource($produto)], 202);
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $produto = Produto::findOrFail($id);
        return response()->json(['message'=>'sucesso', 'produto' => new ProdutoResource($produto)], 202);
    }

    // Listar produtos pelo ID da categoria
    public function showByCategory(string $request)
    { 
        $categoria_ids = array_filter(array_map('intval', explode(',', $request)));

        if (empty($categoria_ids)) {
            return response()->json(['error' => 'Pelo menos uma categoria deve ser especificada.'], 400); 
        }

        $categorias = Categoria::whereIn('id', $categoria_ids)->pluck('nome')->toArray();

        $nome_categorias = implode(' | ', $categorias);

        $produtos = Produto::whereHas('categorias', function ($query) use ($categoria_ids) {
            $query->whereIn('categoria_id', $categoria_ids);
        })->get();

        if ($produtos->isEmpty()) {
            return response()->json(['error' => "Nenhum produto encontrado na(s) categoria(s): $nome_categorias"], 404);
        }

        if(count($categorias)>1){
            return response()->json(['message' => "Categorias: $nome_categorias", 'produtos' => ProdutoResource::collection($produtos)], 200);
        }else{
            return response()->json(['message' => "Categoria: $nome_categorias", 'produtos' => ProdutoResource::collection($produtos)], 200);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProdutoRequest $request, string $id)
    {
        $produto = Produto::findOrFail($id);
        $produto->update($request->validated());
        $produto->categorias()->sync(array_filter($request->input('categoria_id')));
        return response()->json(['message'=>'editado com sucesso', new ProdutoResource($produto)], 202);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $produto = Produto::findOrFail($id);
        $produto->categorias()->detach();
        $produto->delete();
        return response()->json(['message'=>"produto \"{$produto['nome']}\" excluido com sucesso"], 202);
    }
}
