<?php

namespace App\Http\Controllers;

use App\Models\Fornecedor;
use App\Http\Requests\StoreFornecedorRequest;
use App\Http\Requests\UpdateFornecedorRequest;
use App\Http\Resources\FornecedorResource;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;

use Illuminate\Support\Facades\DB;



class FornecedorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fornecedores = Fornecedor::all();
        return response()->json(['fornecedores' => $fornecedores], 202);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFornecedorRequest $request)
    {
        try {
            // Converte resquests (array) em objeto validado
            // $fornecedor = new obj($request->validated());
            $fornecedor = json_decode(json_encode($request->validated()), false);

            // Sanitiza o campo cnpj para conter apenas números
            $cnpj = preg_replace("/[^0-9]/", "", $fornecedor->cnpj);


            // Verificar dígitos verificadores
            if (!empty($cnpj)) {
                // Verifica se o e-cnpj já está cadastrado
                $existingFornecedor = Fornecedor::where('cnpj', $cnpj)->first();
                if ($existingFornecedor) {
                    // return response()->json(['error' => "Erro: Fornecedor \"{$existingFornecedor->cnpj}\" já cadastrado com este CNPJ."], 423); exit();
                    return response()->json(['error' => "Erro: Ha um fornecedor já cadastrado com este CNPJ."], 423); exit();
                }
                // Verifica se o CNPJ possui 14 dígitos ou mais
                if (strlen($cnpj) < 14) {
                    return response()->json(['error' => 'Erro CNPJ ('.strlen($cnpj).') esta incompleto ou inválido'], 501); exit();
                }
                //////////////////////////////////////////////////////////
                // DIGITO VERIFICADOR
                // Calcula o digito verificador
                $soma[] = 0; $soma[] = 0; $multiplo[] = 10; $multiplo[] = 9;
                for($i = 12; $i >= 0; $i--){
                    $soma[0] = $i<12 ? $soma[0]+$cnpj[$i] * $multiplo[0]: $soma[0];
                    $soma[1] += $cnpj[$i] * $multiplo[1];
                    $multiplo[0]--; $multiplo[0] = $multiplo[0] < 2 ? 9 : $multiplo[0]; 
                    $multiplo[1]--; $multiplo[1] = $multiplo[1] < 2 ? 9 : $multiplo[1]; 
                } 
                $DV1 = $soma[0] % 11; $DV2 = $soma[1] % 11;

                // Comparação do dígito com o CNPJ enviado
                if ($DV1 != $cnpj[12] || $DV2 != $cnpj[13]) {
                    return response()->json(['error' => 'Erro CNPJ inválido'], 422); exit();
                }
                //////////////////////////////////////////////////////////
            }

            // Verifica se o e-mail é um formato válido
            $validator = Validator::make($request->all(), [
                'email' => 'nullable|email',
            ])->fails();
            if ($validator) {
                return response()->json(['error' => 'Erro: O e-mail não está em um formato válido.'], 423); exit();
            }

            // Verifica se o e-mail já está cadastrado
            $existingFornecedor = Fornecedor::where('email', $request->input('email'))->first();
            if ($existingFornecedor) {
                // return response()->json(['error' => "Erro: fornecedor \"{$existingFornecedor->nome}\" já cadastrado com este e-mail."], 423); exit();
                return response()->json(['error' => "Erro: Ha um fornecedor já cadastrado com este e-mail."], 423); exit();
            }

            $fornecedor = Fornecedor::create([
                'nome'     => $request->input('nome'),
                'cnpj'     => $cnpj,
                'email'    => $request->input('email'),
                'telefone' => $request->input('telefone'),
                'endereco' => $request->input('endereco'),
                'bairro'   => $request->input('bairro'),
                'cidade'   => $request->input('cidade'),
                'cep'      => $request->input('cep'),
            ]);
            $fornecedor = new FornecedorResource($fornecedor);

            return response()->json(['message' => 'Fornecedor cadastrado com sucesso.', 'fornecedor' => $fornecedor], 202);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro generalizado na operação.'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $fornecedor = Fornecedor::findOrFail($id);

            return response()->json(['message' => 'Fornecedor encontrado com sucesso.', 'fornecedor' => $fornecedor], 202);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Fornecedor não encontrado.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro generalizado na operação.'], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFornecedorRequest $request, $id)
    {
        // \Log::info('Request data:', $request->all()); exit();
        try {
            // Converte resquests (array) em objeto validado
            // $fornecedor = new obj($request->validated());
            $fornecedor = json_decode(json_encode($request->validated()), false);

            // Sanitiza o campo cnpj para conter apenas números
            $cnpj = preg_replace("/[^0-9]/", "", $fornecedor->cnpj);


            // Verificar dígitos verificadores
            if (!empty($cnpj)) {
                // Verifica se o e-cnpj já está cadastrado em outro fornecedor
                $existingFornecedor = Fornecedor::where('cnpj', $cnpj)
                    ->where('id', '!=', $id)
                    ->first();
                if ($existingFornecedor) {
                    // return response()->json(['error' => "Erro: Fornecedor \"{$existingFornecedor->cnpj}\" já cadastrado com este CNPJ."], 423); exit();
                    return response()->json(['error' => "Erro: Ha um fornecedor já cadastrado com este CNPJ."], 423); exit();
                }
                // Verifica se o CNPJ possui 14 dígitos ou mais
                if (strlen($cnpj) < 14) {
                    return response()->json(['error' => 'Erro CNPJ ('.strlen($cnpj).') esta incompleto ou inválido'], 501); exit();
                }
                //////////////////////////////////////////////////////////
                // DIGITO VERIFICADOR
                // Calcula o digito verificador
                $soma[] = 0; $soma[] = 0; $multiplo[] = 10; $multiplo[] = 9;
                for($i = 12; $i >= 0; $i--){
                    $soma[0] = $i<12 ? $soma[0]+$cnpj[$i] * $multiplo[0]: $soma[0];
                    $soma[1] += $cnpj[$i] * $multiplo[1];
                    $multiplo[0]--; $multiplo[0] = $multiplo[0] < 2 ? 9 : $multiplo[0]; 
                    $multiplo[1]--; $multiplo[1] = $multiplo[1] < 2 ? 9 : $multiplo[1]; 
                } 
                $DV1 = $soma[0] % 11; $DV2 = $soma[1] % 11;

                // Comparação do dígito com o CNPJ enviado
                if ($DV1 != $cnpj[12] || $DV2 != $cnpj[13]) {
                    return response()->json(['error' => 'Erro CNPJ inválido'], 422); exit();
                }
                //////////////////////////////////////////////////////////
            }

            // Verifica se o e-mail é um formato válido
            $validator = Validator::make($request->all(), [
                'email' => 'nullable|email',
            ])->fails();
            if ($validator) {
                return response()->json(['error' => 'Erro: O e-mail não está em um formato válido.'], 423); exit();
            }

            // Verifica se o e-mail já está cadastrado em outro fornecedor
            $existingFornecedor = Fornecedor::where('email', $request->input('email'))
                ->where('id', '!=', $id)
                ->first();
            if ($existingFornecedor) {
                // return response()->json(['error' => "Erro: fornecedor \"{$existingFornecedor->nome}\" já cadastrado com este e-mail."], 423); exit();
                return response()->json(['error' => "Erro: Ha um fornecedor já cadastrado com este e-mail."], 423); exit();
            }

            $fornecedor = Fornecedor::findOrFail($id);
            $fornecedor->update([
                'nome' => $request->input('nome'),
                'cnpj' => $cnpj,
                'email' => $request->input('email'),
                'telefone' => $request->input('telefone'),
                'endereco' => $request->input('endereco'),
                'bairro' => $request->input('bairro'),
                'cidade' => $request->input('cidade'),
                'cep' => $request->input('cep'),
            ]);


            $fornecedor = new FornecedorResource($fornecedor);

            return response()->json(['message' => 'Fornecedor editado com sucesso.', 'fornecedor' => $fornecedor], 202);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Fornecedor não encontrado.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro generalizado na operação.'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $fornecedor = Fornecedor::findOrFail($id);
            $fornecedor->delete();

            return response()->json(['message' => 'Fornecedor excluído com sucesso.', 'fornecedor' => $fornecedor], 202);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Fornecedor não encontrado.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro generalizado na operação.'], 500);
        }
    }
}
