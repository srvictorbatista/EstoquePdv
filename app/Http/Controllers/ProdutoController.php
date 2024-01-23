<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;
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
        return ProdutoResource::collection($produtos);
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

        return response()->json(['message'=>'inserido com sucesso', new ProdutoResource($produto)], 202);
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $produto = Produto::findOrFail($id);
        return new ProdutoResource($produto);
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
