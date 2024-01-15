<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venda;
use App\Http\Requests\StoreVendaRequest;
use App\Http\Requests\UpdateVendaRequest;
use App\Http\Resources\VendaResource;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class VendaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vendas = Venda::all();
        return response()->json(['message'=>'lista de vendas', VendaResource::collection($vendas)], 202);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVendaRequest $request)
    {
        // $venda = Venda::create($request->validated());
        $dados_venda = $request->validated();
         $dados_venda['total'] = floatval(str_replace(",", ".", preg_replace("/[^0-9.,]/", "", $dados_venda['total'])));
        $venda = Venda::create($dados_venda);


        // manipula formato da data (momento da venda, apenas no json)
        $data_venda = \DateTime::createFromFormat('Y-m-d H:i:s', $venda->data);
            if (!$data_venda) {
                $data_venda = new \DateTime($venda->data);
            }
            if ($data_venda) {
                $dia_venda = $data_venda->format('d');
                $mes_venda = $data_venda->format('m');
                $ano_venda = $data_venda->format('Y');
                $hor_venda = $data_venda->format('H');
                $min_venda = $data_venda->format('i');
                $seg_venda = $data_venda->format('s');
                // echo "MOMENTO DA VENDA: '{$dia_venda}/{$mes_venda}/{$ano_venda} - {$hor_venda}:{$min_venda}:{$seg_venda}',\n";
            }
        $venda->data = $data_venda->format('Y-m-d H:i:s');
        // echo "eee: '".$data_venda->format('d/m/Y - H:i:s')."'";
        
        return response()->json(['message'=>'inserido com sucesso', new VendaResource($venda)], 202);
    }

    /**
     * Display the specified resource.
     */
    public function show(Venda $venda)
    {
        $venda = Venda::findOrFail($id);
        return new CategoriaResource($venda);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVendaRequest $request, Venda $venda)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Venda $venda)
    {
        //
    }
}
