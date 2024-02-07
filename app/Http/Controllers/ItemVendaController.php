<?php

namespace App\Http\Controllers;

use App\Models\ItemVenda;
use App\Models\Produto;
use App\Models\Venda;
use App\Http\Requests\StoreItemVendaRequest;
use App\Http\Requests\UpdateItemVendaRequest;

class ItemVendaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $itensVenda = ItemVenda::all();
     // return view('itens_venda.index', compact('itensVenda'));
        return response()->json($itensVenda);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreItemVendaRequest $request)
    {
        try {

            $data = $request->validated();

            // obtém o nome do item, da tabela produtos
            $produto = Produto::find($data['produto_id']);

            if ($produto){
                $data['nome_produto'] = $produto->nome;
                $data['descricao'] = $produto->descricao;
            }

            // A quantidade minima é 1
            $data['quantidade'] = isset($data['quantidade']) && $data['quantidade'] >= 1 ? $data['quantidade'] : "1";

            if($produto->quantidade_em_estoque<$data['quantidade']){
                return response()->json(["error"=>"A quantidade em estoque ({$produto->quantidade_em_estoque}) é insuficiente."], 423); exit();
            }

            // Puxa o preço unitario da tabela produtos (se em branco)
            if (!isset($data['preco_unitario'])) {
                $data['preco_unitario'] = $produto->preco;
            }else{
            // Se informado
                $data['preco_unitario'] = number_format(    floatval(str_replace(",", ".", preg_replace("/[^0-9.,]/", "", $data['preco_unitario'])))    , 2, '.', '');
            }

            // Calcula subtotal com base nos valores e quantidades enviados
            if (isset($data['quantidade']) && isset($data['preco_unitario'])) {
                 $data['subtotal'] = number_format(  $data['quantidade'] * $data['preco_unitario'], 2, '.', '');
            }

            // Grava a itemVenda com os dados finais
            $itemVenda = ItemVenda::create($data);

            // subtrai a quantidade do item no estoque
            $produto->quantidade_em_estoque -= $data['quantidade']; $produto->save();

            // Exibe o id inserido
            $data = ['id'=>"{$itemVenda->id}"] + $data;

            
           // recupera os itens desta venda no banco
            $venda = Venda::find($data['venda_id']);
            $itensVenda = $venda->itensVenda;

                foreach ($itensVenda as $itemVenda) {
                    // Relacionamento definido no modelo ItemVenda
                    $produto = $itemVenda->produto;

                    /*
                    $itensVendaData[] = [
                        'produto_nome' => $produto->nome,
                        'produto_descricao' => $produto->descricao,
                        'produto_id' => $produto->id,
                        'quantidade' => $itemVenda->quantidade,
                        'preco_unitario' => $itemVenda->preco_unitario,
                        'subtotal' => $itemVenda->subtotal
                    ];/**/

                    $itensVendaData['subtotal'][] = $itemVenda->subtotal;
                }

            //soma subtotais da venda
            $dados_venda['total'] = number_format(  array_sum($itensVendaData['subtotal']), 2, '.', '');
            // Grava total da venda no db
            $venda->update($dados_venda);


            // return response()->json($itemVenda, 202);
            return response()->json(['message'=>'Adicionado com sucesso!', 'venda'=>['itens'=>count($itensVendaData['subtotal']), 'total'=>$venda->total], 'item'=>$data], 202);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro aa inserir item nesta venda.'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ItemVenda $itemVenda)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateItemVendaRequest $request, ItemVenda $itemVenda)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ItemVenda $itemVenda)
    {
        //
    }
}
