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


        if(empty($dados_venda['produto_id']) || !is_array($dados_venda['produto_id']) || count(array_filter($dados_venda['produto_id'])) < 1): 
            return response()->json(['error' => "Venda precidsa ter produto!"], 400);exit(); 
        endif;

        // Sincroniza os itens da venda
        if (!empty($dados_venda['produto_id']) && !empty(array_filter($dados_venda['produto_id']))) {

            for ($i = 0; $i < count($dados_venda['produto_id']); $i++) {

                if(!empty($dados_venda['produto_id'][$i] )){
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

                    // Verifica se há quantidade em estoque suficiente antes de subtrair
                    if ($produto->quantidade_em_estoque < $dados_venda['quantidade'][$i]) {
                        // Caso não haja quantidade suficiente em estoque
                        return response()->json(['error' => "{$produto->nome}: Estoque insuficiente [id:{$dados_venda['produto_id'][$i]}, q:{$produto->quantidade_em_estoque}]."], 423);  exit();
                    } else {
                        $produto->quantidade_em_estoque -= $dados_venda['quantidade'][$i]; $produto->save();
                    }
                }
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
        return response()->json(['message' => 'Detalhes da venda', 'venda' => [new VendaResource($venda)]], 202);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVendaRequest $request, $id)
    {
        try {
            $venda = Venda::findOrFail($id);
            $dadosVenda = $request->validated();

            if(empty($dadosVenda['produto_id']) || !is_array($dadosVenda['produto_id']) || count(array_filter($dadosVenda['produto_id'])) < 1): 
                return response()->json(['error' => "Venda precidsa conter produto!"], 423); exit(); 
            endif;

            // Obtem as quantidades anteriores dos itens desta venda
            $quantidadesAnteriores = [];
            foreach ($venda->itensVenda as $itemVenda):
                $quantidadesAnteriores[$itemVenda->produto_id] = $itemVenda->quantidade;
            endforeach;

            // Devolve as quantidades anteriores ao estoque
            foreach ($quantidadesAnteriores as $produtoId => $quantidade):
                $produto = Produto::find($produtoId);
                $produto->quantidade_em_estoque += $quantidade;
                $produto->save();
            endforeach;

            // Sincronizar os novos itens da venda
            $itensVendaSinc = [];
            $itensVenda = [];
            for ($i = 0; $i < count(array_filter($dadosVenda['produto_id'])); $i++):
                $produto = Produto::find($dadosVenda['produto_id'][$i]);

                $dadosVenda['produto_nome'][$i] = $produto->nome;
                $dadosVenda['produto_descricao'][$i] = $produto->descricao;

                $dadosVenda['preco_unitario'][$i] = empty($dadosVenda['preco_unitario'][$i]) ? $produto->preco : number_format(floatval(preg_replace("/[^0-9.,]/", "", str_replace(",", ".", $dadosVenda['preco_unitario'][$i]))), 2, '.', '');

                $dadosVenda['quantidade'][$i] = isset($dadosVenda['quantidade'][$i]) && $dadosVenda['quantidade'][$i] >= 1 ? $dadosVenda['quantidade'][$i] : "1";

                $dadosVenda['subtotal'][$i] = isset($dadosVenda['quantidade'][$i]) && isset($dadosVenda['preco_unitario'][$i]) ? number_format($dadosVenda['quantidade'][$i] * $dadosVenda['preco_unitario'][$i], 2, '.', '') : $dadosVenda['preco_unitario'][$i];

                $itensVenda[] = [
                    'produto_nome' => $dadosVenda['produto_nome'][$i],
                    'produto_descricao' => $dadosVenda['produto_descricao'][$i],
                    'produto_id' => $dadosVenda['produto_id'][$i],
                    'quantidade' => $dadosVenda['quantidade'][$i],
                    'preco_unitario' => $dadosVenda['preco_unitario'][$i],
                    'subtotal' => $dadosVenda['subtotal'][$i],
                ];

                $itensVendaSinc[$dadosVenda['produto_id'][$i]] = [
                    'quantidade' => isset($dadosVenda['quantidade'][$i]) ? floatval(str_replace(",", ".", preg_replace("/[^0-9.,]/", "", $dadosVenda['quantidade'][$i]))) : 1,
                    'preco_unitario' => isset($dadosVenda['preco_unitario'][$i]) ? floatval(str_replace(",", ".", preg_replace("/[^0-9.,]/", "", $dadosVenda['preco_unitario'][$i]))) : 0,
                    'subtotal' => $dadosVenda['subtotal'][$i],
                ];

                // Verifica em todos os itens se há quantidade suficiente, antes de subtrair do estoque
                if ($produto->quantidade_em_estoque < $dadosVenda['quantidade'][$i]) {
                    $itemEmFalta['error'] = ["Edição não realizada"];
                    $itemEmFalta['description'][] = "{$produto->nome}: Estoque insuficiente [id: {$produto->id}, quantidade_em_estoque: {$produto->quantidade_em_estoque}].";
                };
            endfor;

                $dadosVenda['total'] = number_format(  array_sum($dadosVenda['subtotal']), 2, '.', '');

            
            foreach ($itensVendaSinc as $produtoId => $itemVenda):
                $produto = Produto::find($produtoId);

                // Verifica se algum intem não teve estoque insuficiente
                if (!empty($itemEmFalta)) {
                    // Caso o estoque seja insuficiente, devolve todas as quantidades que foram retiradas no inicio
                    $produto->quantidade_em_estoque -=$quantidadesAnteriores[$produto->id]; $produto->save();
                } else {
                    // Subtrai a quantidade vendida do estoque (tabela de produtos)
                    $produto->quantidade_em_estoque -= $itemVenda['quantidade']; $produto->save();
                }
            endforeach;

            //  Se for o caso, apresenta retorno de estoque insuficiente e interrompe a edicao da venda
            if (!empty($itemEmFalta)) {
                return response()->json($itemEmFalta, 423);  exit();
            }

            // Atualiza os dados da venda e sincronizar os novos itens
            $venda->itensVendaU()->sync($itensVendaSinc);
            $venda->update($dadosVenda);

            // Exibe os dados atualizados
            $vendaAtualizada = Venda::with(['itensVenda.produto:id,nome,descricao', 'itensVenda'])->findOrFail($id);
            $vendaData[] = [
                'id' => $venda->id,
                'data' => $venda->data,
                'total' => $venda->total,
                'itens' => $itensVenda,
            ];

            return response()->json(['message' => 'Editado com sucesso', 'venda' => $vendaData], 202);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Erro: venda não encontrada'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro generalizado na operação'], 500);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
                $venda = Venda::findOrFail($id);
                    // return response()->json(['itensVenda' => $venda->itensVenda], 200); exit();

                // Devolve a quantidade dos itens vendidos ao estoque
                foreach ($venda->itensVenda as $itemVenda) {
                    $produto = Produto::find($itemVenda->produto_id);

                    $itens_estornados[] = [
                    'produto_nome' => $produto->nome,
                    'produto_descricao' => $produto->descricao,
                    'produto_id' => $produto->id,
                    'quantidade' => $itemVenda->quantidade,
                    'preco_unitario' => $itemVenda->preco_unitario,
                    'subtotal' => $itemVenda->subtotal,
                    ];
                    $produto->quantidade_em_estoque += $itemVenda->quantidade;
                    $produto->save();
                }

                // Detach os itens desta venda
                $venda->itensVendaU()->detach();

                // Exclui a venda
                $venda->delete();

                return response()->json(['message' => "Venda excluída com sucesso.","total"=>$venda->total, 'itens_estornados'=>$itens_estornados], 202);
            } catch (ModelNotFoundException $e) {
                return response()->json(['error' => 'Venda não encontrada.'], 404);
            } catch (\Exception $e) {
                return response()->json(['error' => 'Erro ao excluir a venda.'], 500);
            }
        }
}
