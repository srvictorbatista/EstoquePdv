<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;
use App\Http\Requests\StoreCategoriaRequest;
use App\Http\Requests\UpdateCategoriaRequest;
use App\Http\Resources\CategoriaResource;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categorias = Categoria::all();
        // return CategoriaResource::collection($categorias);
        return response()->json(['message'=>'lista de categorias', CategoriaResource::collection($categorias)], 202);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoriaRequest $request)
    {
        $categoria = Categoria::create($request->validated());
        return response()->json(['message'=>'inserido com sucesso', new CategoriaResource($categoria)], 202);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $categoria = Categoria::findOrFail($id);
        return new CategoriaResource($categoria);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoriaRequest $request, $id) // Edit categorias com tratativas de erro (retorno json)
    {
        try {
            $categoria = Categoria::findOrFail($id);        
            $categoria->update($request->validated());
            return response()->json(['message' => 'editado com sucesso', new CategoriaResource($categoria)], 202);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Erro Categoria não encontrada'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro generalizado na operação'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $categoria = Categoria::findOrFail($id);
        $categoria->delete();        
        return response()->json(['message'=>"A categoria \"{$categoria['nome']}\" foi excluida com sucesso",  CategoriaResource::collection(Categoria::all())], 202);
    }
}
