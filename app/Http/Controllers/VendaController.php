<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venda;
use App\Models\Produto;
// use App\Models\ItemVenda;
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
        $vendasData = [];

        foreach ($vendas as $venda) {
            // Relacionamento definido no model Venda
            $itensVenda = $venda->itensVenda;
            $itensVendaData = [];
            $itemVendaTotal=0;

            foreach ($itensVenda as $itemVenda) {
                // Relacionamento definido no modelo ItemVenda
                $produto = $itemVenda->produto;

                $itensVendaData[] = [
                    'produto_nome' => $produto->nome,
                    'produto_descricao' => $produto->descricao,
                    'produto_id' => $produto->id,
                    'quantidade' => $itemVenda->quantidade,
                    'preco_unitario' => $itemVenda->preco_unitario,
                    'subtotal' => $itemVenda->subtotal
                ];
            }

            $vendasData[] = [
                'venda_id'  => $venda->id,
                'data'      => $venda->data,
                'total'     => $venda->total,
                'itens'     => $itensVendaData,
            ];
        }

        return response()->json(['message' => 'Lista de vendas', 'vendas' => $vendasData], 202);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVendaRequest $request)
    {
        $dados_venda = $request->validated();
        // Certifica-se de que o campo 'total' existe e é um valor numérico (caso não haja itens na venda)
        // $dados_venda['total'] = isset($dados_venda['total']) ? floatval(str_replace(",", ".", preg_replace("/[^0-9.,]/", "", $dados_venda['total']))) : 0;
        $dados_venda['total'] = 0;
        $itensVenda = [];

        // Sincroniza os itens da venda
        if (!empty($dados_venda['produto_id']) && !empty(array_filter($dados_venda['produto_id']))) {

            for ($i = 0; $i < count(array_filter($dados_venda['produto_id'])); $i++) {

                $produto = Produto::find($dados_venda['produto_id'][$i]);
                $dados_venda['produto_nome'][$i] = $produto->nome;
                $dados_venda['produto_descricao'][$i] = $produto->descricao;

                // Puxa o preço unitario da tabela produtos (se em branco)
                if (empty($dados_venda['preco_unitario'][$i])) {
                    $dados_venda['preco_unitario'][$i] = $produto->preco;
                }else{
                // Se informado
                    $dados_venda['preco_unitario'][$i] = number_format(    floatval(str_replace(",", ".", preg_replace("/[^0-9.,]/", "", $dados_venda['preco_unitario'][$i])))    , 2, '.', '');
                }

                // A quantidade minima é 1
                if (!isset($dados_venda['quantidade'][$i]) || empty($dados_venda['quantidade'][$i]) || $dados_venda['quantidade'][$i] < 1) {
                    $dados_venda['quantidade'][$i] = "1";
                }

                // Calcula subtotal com base nos valores e quantidades
                if (isset($dados_venda['quantidade'][$i]) && isset($dados_venda['preco_unitario'][$i])) {
                     $dados_venda['subtotal'][$i] = number_format(  $dados_venda['quantidade'][$i] * $dados_venda['preco_unitario'][$i], 2, '.', '');
                }

                $itensVenda[] = [
                    'produto_nome' => $dados_venda['produto_nome'][$i],
                    'produto_descricao' => $dados_venda['produto_descricao'][$i],
                    'produto_id' => $dados_venda['produto_id'][$i],
                    'quantidade' => $dados_venda['quantidade'][$i],
                    'preco_unitario' => $dados_venda['preco_unitario'][$i],
                    'subtotal' => $dados_venda['subtotal'][$i],
                ];
            }

            $itensVendaTotal = number_format(  array_sum($dados_venda['subtotal']), 2, '.', '');
            $dados_venda['total'] = $itensVendaTotal;
        }

        $venda = Venda::create($dados_venda);


        if (!empty($dados_venda['produto_id'])) {
            $venda->itensVenda()->createMany($itensVenda);
        }

        //* manipula formato da data (momento da venda, apenas no json)
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

            $vendaData[] = [
                'id'        => $venda->id,
                'data'      => $venda->data,
                'total'     => $venda->total,   // Exibe o total registrado no banco
                'itens'     => $itensVenda,
            ];


        // Retorna a resposta
        return response()->json(['message' => 'Inserido com sucesso', 'venda' => $vendaData], 202);
    }

    /**
     * Display the specified resource.
     */
    public function show(Venda $request, $id)
    {
        $venda = Venda::findOrFail($id);
        return new VendaResource($venda);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVendaRequest $request, $id)
    {
        /*
        try {
            $venda = Venda::findOrFail($id);
            $venda->update($request->validated());

            // Sincroniza os itens da venda
            if ($request->has('produto_id')) {
                $produtoIds = $request->input('produto_id');
                $quantidades = $request->input('quantidade');
                $precosUnitarios = $request->input('preco_unitario');

                $itensVenda = [];
                for ($i = 0; $i < count($produtoIds); $i++) {
                    $itensVenda[$produtoIds[$i]] = [
                        'quantidade' => $quantidades[$i],
                        'preco_unitario' => $precosUnitarios[$i],
                    ];
                }

                $venda->itensVenda()->sync($itensVenda);
            }

            // Exibe os dados atualizados
            $vendaAtualizada = Venda::with(['itensVenda.produto:id,nome,descricao', 'itensVenda'])->findOrFail($id);

            // Formata os dados conforme o desejado na resposta JSON
            $vendaFormatada = [
                'id' => $vendaAtualizada->id,
                'data' => $vendaAtualizada->data,
                'total' => number_format($vendaAtualizada->total, 2),
                'itens' => $vendaAtualizada->itensVenda->map(function ($itemVenda) {
                    return [
                        'produto_nome' => $itemVenda->produto->nome,
                        'produto_descricao' => $itemVenda->produto->descricao,
                        'produto_id' => $itemVenda->produto->id,
                        'quantidade' => $itemVenda->quantidade,
                        'preco_unitario' => number_format($itemVenda->preco_unitario, 2),
                        'subtotal' => number_format($itemVenda->subtotal, 2),
                    ];
                }),
            ];

            return response()->json(['message' => 'Editado com sucesso', 'venda' => [$vendaFormatada]], 202);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Erro: venda não encontrada'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro generalizado na operação'], 500);
        }/**/



        //*
        try {

            $venda = Venda::findOrFail($id);
            $dados_venda = $request->validated();

        // Sincroniza os itens da venda
        if (!empty($dados_venda['produto_id']) && !empty(array_filter($dados_venda['produto_id']))) {
            $itensVenda = [];
            $itensVendaSinc = [];
            for ($i = 0; $i < count(array_filter($dados_venda['produto_id'])); $i++) {

                    $produto = Produto::find($dados_venda['produto_id'][$i]);
                    $dados_venda['produto_nome'][$i] = $produto->nome;
                    $dados_venda['produto_descricao'][$i] = $produto->descricao;

                    // Puxa o preço unitario da tabela produtos (se em branco)
                    if (empty($dados_venda['preco_unitario'][$i])) {
                        $dados_venda['preco_unitario'][$i] = $produto->preco;
                    }else{
                    // Se informado
                        $dados_venda['preco_unitario'][$i] = number_format(    floatval(str_replace(",", ".", preg_replace("/[^0-9.,]/", "", $dados_venda['preco_unitario'][$i])))    , 2, '.', '');
                    }

                    // A quantidade minima é 1
                    if (!isset($dados_venda['quantidade'][$i]) || empty($dados_venda['quantidade'][$i]) || $dados_venda['quantidade'][$i] < 1) {
                        $dados_venda['quantidade'][$i] = "1";
                    }

                    // Calcula subtotal com base nos valores e quantidades
                    if (isset($dados_venda['quantidade'][$i]) && isset($dados_venda['preco_unitario'][$i])) {
                         $dados_venda['subtotal'][$i] = number_format(  $dados_venda['quantidade'][$i] * $dados_venda['preco_unitario'][$i], 2, '.', '');
                    }

                    $itensVenda[] = [
                        'produto_nome' => $dados_venda['produto_nome'][$i],
                        'produto_descricao' => $dados_venda['produto_descricao'][$i],
                        'produto_id' => $dados_venda['produto_id'][$i],
                        'quantidade' => $dados_venda['quantidade'][$i],
                        'preco_unitario' => $dados_venda['preco_unitario'][$i],
                        'subtotal' => $dados_venda['subtotal'][$i],
                    ];


                    $itensVendaSinc[$dados_venda['produto_id'][$i]] = [
                        'quantidade' => isset($dados_venda['quantidade'][$i]) ? floatval(str_replace(",", ".", preg_replace("/[^0-9.,]/", "", $dados_venda['quantidade'][$i]))) : 1,
                        'preco_unitario' => isset($dados_venda['preco_unitario'][$i]) ? floatval(str_replace(",", ".", preg_replace("/[^0-9.,]/", "", $dados_venda['preco_unitario'][$i]))) : 0,
                        'subtotal' => $dados_venda['subtotal'][$i],
                    ];
            }
            
            $itensVendaTotal = number_format(  array_sum($dados_venda['subtotal']), 2, '.', '');
            $dados_venda['total'] = $itensVendaTotal;
            $venda->itensVendaU()->sync($itensVendaSinc);
            $venda->update($dados_venda);

        }

            // Exibe os dados atualizados
            // $vendaAtualizada = Venda::with('itensVenda.produto')->findOrFail($id);
            $vendaAtualizada = Venda::with(['itensVenda.produto:id,nome,descricao', 'itensVenda'])->findOrFail($id);
              $vendaData[] = [
                'id'        => $venda->id,
                'data'      => $venda->data,
                'total'     => $venda->total,   // Exibe o total registrado no banco
                'itens'     => $itensVenda,
            ];

        
            // return response()->json(['message' => 'Editado com sucesso', 'venda' => new VendaResource($vendaAtualizada)], 202);
            return response()->json(['message' => 'Editado com sucesso', 'venda' => $vendaData], 202);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Erro: venda não encontrada'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro generalizado na operação'], 500);
        }/**/
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Venda $venda)
    {
        //
    }
}
