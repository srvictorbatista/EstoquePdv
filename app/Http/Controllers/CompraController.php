<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Compra;
use App\Models\Produto;
use App\Models\Fornecedor;
use App\Models\RelCompraProduto;
use App\Http\Requests\StoreCompraRequest;
use App\Http\Requests\UpdateCompraRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CompraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    { 
        
        $compras = Compra::with(['Fornecedores', 'itensCompra.produto'])->get();

        $comprasData = [];

        foreach ($compras as $compra) {
            $itensCompraData = [];
            $fornecedoresData = [];

            foreach ($compra->itensCompra as $itemCompra) {
                $itensCompraData[] = [
                    'produto_nome'		=> $itemCompra->produto->nome,
                    'produto_descricao' => $itemCompra->produto->descricao,
                    'produto_id' 		=> $itemCompra->produto_id,
                    'quantidade' 		=> $itemCompra->quantidade,
                    'preco_unitario' 	=> $itemCompra->preco_unitario,
                    'subtotal'			=> $itemCompra->subtotal,
                ];
            }

            foreach ($compra->Fornecedores as $fornecedor) {
                $fornecedoresData[] = [
                    'fornecedor_id' => $fornecedor->id,
                    'nome' => $fornecedor->nome,
                    'cnpj' => $fornecedor->cnpj,
                    'telefone' => $fornecedor->telefone,
                    'endereco' => $fornecedor->endereco,
                    'bairro' => $fornecedor->bairro,
                    'cidade' => $fornecedor->cidade,
                ];
            }

            $comprasData[] = [
                'id' => $compra->id,
                'fornecedor' => $fornecedoresData,
                'data' => $compra->data,
                'total' => $compra->total,
                'itens' => $itensCompraData,
            ];
        }

        return response()->json(['message' => 'Lista de compras', 'compras' => $comprasData], 202);
    }

    /**
     * Store a newly created resource in storage.
     */
	public function store(StoreCompraRequest $request)
	{

	   try {
	        $dados_compra = $request->validated();
	        $dados_compra['total'] = 0;
	        $itensCompra = [];
            
            // retrorno de teste
            // return response()->json(['CALLBACK' => $compra], 202); exit();

            // Verifica se ao menos 1 fornecedor foi informado, caso contrário, associa ao fornecedor padrão (ID 0)
            $dados_compra['fornecedor_id'][0] = isset($dados_compra['fornecedor_id'][0]) ? $dados_compra['fornecedor_id'][0] : 0;

            // itera clientes para um objeto fornecedor array
            if (!empty($dados_compra['fornecedor_id'])) {
                for ($i = 0; $i < count($dados_compra['fornecedor_id']); $i++) {
                    // associa o ID informado ao fornecedor
                    $fornecedor_obj[] = Fornecedor::find($dados_compra['fornecedor_id'][$i]);

                    $fornecedor[] = [
                        'id' => $fornecedor_obj[$i]['id'],
                        'nome' => $fornecedor_obj[$i]['nome'],
                        'cnpj' => $fornecedor_obj[$i]['cnpj'],
                        'telefone' => $fornecedor_obj[$i]['telefone'],
                        'endereco' => $fornecedor_obj[$i]['endereco'],
                        'bairro' => $fornecedor_obj[$i]['bairro'],
                        'cidade' => $fornecedor_obj[$i]['cidade'],
                    ];
                }
            }

            if(empty($dados_compra['produto_id']) || !is_array($dados_compra['produto_id']) || count(array_filter($dados_compra['produto_id'])) < 1): 
                return response()->json(['error' => "Compra precidsa ter produto!"], 400); exit(); 
            endif;

            // Sincroniza os itens da compra
            if (!empty($dados_compra['produto_id']) && !empty(array_filter($dados_compra['produto_id']))) {

                for ($i = 0; $i < count($dados_compra['produto_id']); $i++) {

                    if(!empty($dados_compra['produto_id'][$i] )){
                        $produto = Produto::find($dados_compra['produto_id'][$i]);
                        $dados_compra['produto_nome'][$i] = $produto->nome;
                        $dados_compra['produto_descricao'][$i] = $produto->descricao;

                        // Verifica se o produto existe
                        if (!$produto) {
                            return response()->json(['error' => "Produto não encontrado para o ID {$dados_compra['produto_id'][$i]}"], 404); exit();
                        }

                        // Puxa o preço unitario da tabela produtos (se em branco)
                        if (empty($dados_compra['preco_unitario'][$i])) {
                            $dados_compra['preco_unitario'][$i] = $produto->preco;
                        }else{
                        // Se informado
                            $dados_compra['preco_unitario'][$i] = number_format(    floatval(str_replace(",", ".", preg_replace("/[^0-9.,]/", "", $dados_compra['preco_unitario'][$i])))    , 2, '.', '');
                        }

                        // A quantidade minima é 1
                        $dados_compra['quantidade'][$i] = isset($dados_compra['quantidade'][$i]) && $dados_compra['quantidade'][$i] > 0 ? $dados_compra['quantidade'][$i] : "1";


                        // Calcula subtotal com base nos valores e quantidades
                        if (isset($dados_compra['quantidade'][$i]) && isset($dados_compra['preco_unitario'][$i])) {
                             $dados_compra['subtotal'][$i] = number_format(  $dados_compra['quantidade'][$i] * $dados_compra['preco_unitario'][$i], 2, '.', '');
                        }

                        $itensCompra[] = [
                            'produto_nome' => $dados_compra['produto_nome'][$i],
                            'produto_descricao' => $dados_compra['produto_descricao'][$i],
                            'produto_id' => $dados_compra['produto_id'][$i],
                            'quantidade' => $dados_compra['quantidade'][$i],
                            'preco_unitario' => $dados_compra['preco_unitario'][$i],
                            'subtotal' => $dados_compra['subtotal'][$i],
                        ];

                        // Adiciona (soma) quantidades ao estoque
                        $produto->quantidade_em_estoque += $dados_compra['quantidade'][$i]; $produto->save();
                    }
                }

                $itensCompraTotal = number_format(  array_sum($dados_compra['subtotal']), 2, '.', '');
                $dados_compra['total'] = $itensCompraTotal;
            }


            $compra = Compra::create($dados_compra); $compra->data = date('Y-m-d H:i:s');





            if (!empty($dados_compra['fornecedor_id'])) {
                $compra->fornecedores()->attach($dados_compra['fornecedor_id']);
                //$compra->fornecedores()->associate($dados_compra['fornecedor_id'])->save();
            }


            if (!empty($dados_compra['produto_id'])) {
                $compra->itensCompra()->createMany($itensCompra);
            }


             $compra_data[] = [
            	'id' 			=> $compra->id,
            	'fornecedor' 	=> $fornecedor,
	            'data' 			=> $compra->data,
	            'total' 		=> $compra->total,
            	'itens' 		=> $itensCompra,
            ];

            return response()->json(['message' => 'Compra registrada com sucesso', 'compra' => $compra_data], 202);
	    } catch (ModelNotFoundException $e) {
	        return response()->json(['error' => 'Erro: Fornecedor ou Produto não encontrado'], 404);
	    } catch (\Exception $e) {
	        return response()->json(['error' => 'Erro ao processar a compra'], 500);
	    }
	}

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        
        try {
            $compra = Compra::with(['itensCompra', 'Fornecedores', 'relCompraProdutos'])->findOrFail($id);
            
            // retrorno de teste
            // return response()->json(['CALLBACK' => $compra], 202); exit();

            $itensCompraData = [];
            $fornecedoresData = [];

            foreach ($compra->itensCompra as $itemCompra) {
                $itensCompraData[] = [
                    'produto_nome'		=> $itemCompra->produto->nome,
                    'produto_descricao' => $itemCompra->produto->descricao,
                    'produto_id' 		=> $itemCompra->produto_id,
                    'quantidade' 		=> $itemCompra->quantidade,
                    'preco_unitario' 	=> $itemCompra->preco_unitario,
                    'subtotal'			=> $itemCompra->subtotal,
                ];

            }

            foreach ($compra->Fornecedores as $fornecedor) {
                $fornecedoresData[] = [
                    'fornecedor_id' => $fornecedor->id,
                    'nome' 			=> $fornecedor->nome,
                    'cnpj' 			=> $fornecedor->cnpj,
                    'telefone' 		=> $fornecedor->telefone,
                    'endereco' 		=> $fornecedor->endereco,
                    'bairro' 		=> $fornecedor->bairro,
                    'cidade' 		=> $fornecedor->cidade,
                ];
            }

            $compraData = [
                'id' 			=> $compra->id,
                'fornecedor' 	=> $fornecedoresData,
                'data' 			=> $compra->data,
                'total' 		=> $compra->total,
                'itens' 		=> $itensCompraData,
            ];

            return response()->json(['message' => 'Detalhes da compra', 'compra' => $compraData], 202);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Compra não encontrada'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCompraRequest $request, $id)
    {
        try {
            $compra = Compra::findOrFail($id);
            $dadosCompra = $request->validated();

            if (empty($dadosCompra['produto_id']) || !is_array($dadosCompra['produto_id']) || count(array_filter($dadosCompra['produto_id'])) < 1) {
                return response()->json(['error' => "Compra precisa conter produto!"], 423);
            }

            // Busca as quantidades anteriores dos itens desta compra
            $quantidadesAnteriores = [];
            foreach ($compra->itensCompra as $itemCompra):
                $quantidadesAnteriores[$itemCompra->produto_id] = $itemCompra->quantidade;
            endforeach;

            // Retira as quantidades do estoque
            foreach ($quantidadesAnteriores as $produtoId => $quantidade):
                $produto = Produto::find($produtoId);
                $produto->quantidade_em_estoque -= $quantidade;
                $produto->save();
            endforeach;

            // Sincroniza os novos itens da compra
            $itensCompraSinc = [];
            $itensCompra = [];
            for ($i = 0; $i < count(array_filter($dadosCompra['produto_id'])); $i++):
                $produto = Produto::find($dadosCompra['produto_id'][$i]);

                $dadosCompra['produto_nome'][$i] = $produto->nome;
                $dadosCompra['produto_descricao'][$i] = $produto->descricao;

                $dadosCompra['preco_unitario'][$i] = empty($dadosCompra['preco_unitario'][$i]) ? $produto->preco : number_format(floatval(preg_replace("/[^0-9.,]/", "", str_replace(",", ".", $dadosCompra['preco_unitario'][$i]))), 2, '.', '');

                $dadosCompra['quantidade'][$i] = isset($dadosCompra['quantidade'][$i]) && $dadosCompra['quantidade'][$i] >= 1 ? $dadosCompra['quantidade'][$i] : "1";

                $dadosCompra['subtotal'][$i] = isset($dadosCompra['quantidade'][$i]) && isset($dadosCompra['preco_unitario'][$i]) ? number_format($dadosCompra['quantidade'][$i] * $dadosCompra['preco_unitario'][$i], 2, '.', '') : $dadosCompra['preco_unitario'][$i];

                $itensCompra[] = [
                    'produto_nome' => $dadosCompra['produto_nome'][$i],
                    'produto_descricao' => $dadosCompra['produto_descricao'][$i],
                    'produto_id' => $dadosCompra['produto_id'][$i],
                    'quantidade' => $dadosCompra['quantidade'][$i],
                    'preco_unitario' => $dadosCompra['preco_unitario'][$i],
                    'subtotal' => $dadosCompra['subtotal'][$i],
                ];

                $itensCompraSinc[$dadosCompra['produto_id'][$i]] = [
                    'quantidade' => isset($dadosCompra['quantidade'][$i]) ? floatval(str_replace(",", ".", preg_replace("/[^0-9.,]/", "", $dadosCompra['quantidade'][$i]))) : 1,
                    'preco_unitario' => isset($dadosCompra['preco_unitario'][$i]) ? floatval(str_replace(",", ".", preg_replace("/[^0-9.,]/", "", $dadosCompra['preco_unitario'][$i]))) : 0,
                    'subtotal' => $dadosCompra['subtotal'][$i],
                ];

                // Verifica em todos os itens se há quantidade é válida
                /*
                if (($produto->quantidade_em_estoque+$itemCompra['quantidade']) < 1) {
                    $itemError['error'] = ["Edição não realizada"];
                    $itemError['description'][] = "{$produto->nome}: Quantidade insuficiente [id: {$produto->id}, quantidade em estoque: {$produto->quantidade_em_estoque}].";
                };/**/


            // retrorno de teste
            // return response()->json(['CALLBACK' => ($produto->quantidade_em_estoque+$itemCompra['quantidade'])." + ".$itemCompra['quantidade'] ], 202); exit();

            endfor;

            $dadosCompra['total'] = number_format(array_sum($dadosCompra['subtotal']), 2, '.', '');
            $dadosCompra['created_at'] = $compra->created_at;
            $dadosCompra['updated_at'] = now();

            foreach ($itensCompraSinc as $produtoId => $itemCompra):
                $produto = Produto::find($produtoId);

                // Verifica se algum item não teve estoque insuficiente
                /*
                if (!empty($itemError)) {
                    // Caso o estoque seja insuficiente, devolve todas as quantidades que foram retiradas no início
                    $produto->quantidade_em_estoque += $quantidadesAnteriores[$produto->id];
                    $produto->save();
                } else {/**/
                    // Soma a quantidade comprada ao estoque (tabela de produtos)
                    $produto->quantidade_em_estoque += $itemCompra['quantidade'];
                    $produto->save();
                //}
            endforeach;

            // Se for o caso, apresenta retorno de estoque insuficiente e interrompe a edição da compra
            if (!empty($itemError)) {
                return response()->json($itemError, 423);
            }

            // Atualiza os dados da compra e sincroniza os novos itens
            $compra->itensCompraU()->sync($itensCompraSinc);
            $compra->update($dadosCompra);

            // Atualiza os fornecedores da compra
            $fornecedores = [];
            if (isset($dadosCompra['fornecedor_id'])) {
                foreach ($dadosCompra['fornecedor_id'] as $fornecedorId) {
                    $fornecedores[] = Fornecedor::find($fornecedorId);
                }
            }

            if (!empty($dadosCompra['fornecedor_id'])) {
                try {
                    $compra->Fornecedores()->detach(); // Remove as associações antigas
                    $compra->Fornecedores()->attach($dadosCompra['fornecedor_id']); // Adiciona as novas associações
                } catch (\Exception $e) {
                    return response()->json(['error' => 'Erro durante a sincronização de fornecedores: ' . $e->getMessage()], 500);
                }
            }

            // Exibe os dados atualizados
            // $compraAtualizada = Compra::with(['itensCompraU.produto:id,nome,descricao', 'Fornecedores', 'relCompraProdutos'])->findOrFail($id);
            $compraAtualizada = Compra::with(['Fornecedores'])->findOrFail($id);

            $compraData[] = [
                'id' => $compra->id,
                'fornecedor' => $compraAtualizada->Fornecedores->map(function ($fornecedor) {
                    return [
                        'id' => $fornecedor->id,
                        'nome' => $fornecedor->nome,
                        'cnpj' => $fornecedor->cnpj,
                        'telefone' => $fornecedor->telefone,
                        'endereco' => $fornecedor->endereco,
                        'bairro' => $fornecedor->bairro,
                        'cidade' => $fornecedor->cidade,
                    ];
                }),
                'data' => $compra->data,
                'total' => $compra->total,
                'itens' => $itensCompra,
            ];

            return response()->json(['message' => 'Editado com sucesso', 'compra' => $compraData], 202);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Erro: Compra não encontrada'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro generalizado na operação'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $compra = Compra::with(['Fornecedores'])->findOrFail($id); // Compra::findOrFail($id);

            // Retira do estoque as quantidades dos itens desta compra
            foreach ($compra->itensCompra as $itemCompra):
                $produto = Produto::find($itemCompra->produto_id);
                $produto->quantidade_em_estoque -= $itemCompra->quantidade;
                $produto->save();
                $itensCompra[] = [
                    'produto_nome' => $produto->nome,
                    'produto_descricao' => $produto->descricao,
                    'produto_id' => $produto->id,
                    'quantidade' => $itemCompra->quantidade,
                    'preco_unitario' => $produto->preco,
                    'subtotal' => $itemCompra->subtotal,
                ];
            endforeach;

            $compraData[] = [
                'id' => $compra->id,
                'fornecedor' => $compra->Fornecedores->map(function ($fornecedor) {
                    return [
                        'id' => $fornecedor->id,
                        'nome' => $fornecedor->nome,
                        'cnpj' => $fornecedor->cnpj,
                        'telefone' => $fornecedor->telefone,
                        'endereco' => $fornecedor->endereco,
                        'bairro' => $fornecedor->bairro,
                        'cidade' => $fornecedor->cidade,
                    ];
                }),
                'data' => $compra->data,
                'total' => $compra->total,
                'itens' => $itensCompra,
            ];

            $compra->Fornecedores()->detach();
            $compra->itensCompraU()->detach();
            $compra->delete();

            return response()->json(['message' => 'Compra excluída com sucesso', 'compra' => $compraData], 202);        
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Erro: Compra não encontrada'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro generalizado na operação'], 500);
        }
    }
}
