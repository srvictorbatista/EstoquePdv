<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Http\Requests\StoreClienteRequest;
use App\Http\Requests\UpdateClienteRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;



class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clientes = Cliente::all();

        return response()->json(['clientes' => $clientes], 202);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClienteRequest $request)
    {     
        

        try {
            // Sanitiza o campo CPF para conter apenas números
            $cpf = preg_replace("/[^0-9]/", "", $request->input('cpf'));


            // Verificar dígitos verificadores
            if (!empty($cpf)) {
                // Verifica se o e-cpf já está cadastrado
                $existingCliente = Cliente::where('cpf', $cpf)->first();
                if ($existingCliente) {
                    // return response()->json(['error' => "Erro: Cliente \"{$existingCliente->nome}\" já cadastrado com este CPF."], 423); exit();
                    return response()->json(['error' => "Erro: Ha um cliente já cadastrado com este CPF."], 423); exit();
                }
                // Verifica se o CPF possui 11 dígitos ou mais
                if (strlen($cpf) < 11) {
                    return response()->json(['error' => 'Erro cpf ('.strlen($cpf).') esta incompleto ou inválido'], 501); exit();
                }
                //////////////////////////////////////////////////////////
                // DIGITO VERIFICADOR
                // Calcula o digito verificador
                $soma[] = 0; $soma[] = 0;
                for ($i = 0; $i < 10; $i++) {
                    $soma[0] = $i<9 ? $soma[0]+$cpf[$i] * (10 - $i): $soma[0];
                    $soma[1] += $cpf[$i] * (11 - $i);
                }
                $DV1 = ($soma[0] % 11) > 1 ? 11 - ($soma[0] % 11) : 0;
                $DV2 = ($soma[1] % 11) > 1 ? 11 - ($soma[1] % 11) : 0;

                // Comparação do dígito com o CPF enviado
                if ($DV1 != $cpf[9] || $DV2 != $cpf[10]) {
                    return response()->json(['error' => 'Erro cpf inválido'], 422); exit();
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
            $existingCliente = Cliente::where('email', $request->input('email'))->first();
            if ($existingCliente) {
                // return response()->json(['error' => "Erro: Cliente \"{$existingCliente->nome}\" já cadastrado com este e-mail."], 423); exit();
                return response()->json(['error' => "Erro: Ha um cliente já cadastrado com este e-mail."], 423); exit();
            }

            $cliente = Cliente::create([
                'nome'     => $request->input('nome'),
                'cpf'      => $cpf,
                'email'    => $request->input('email'),
                'telefone' => $request->input('telefone'),
                'endereco' => $request->input('endereco'),
                'bairro'   => $request->input('bairro'),
                'cidade'   => $request->input('cidade'),
                'cep'      => $request->input('cep'),
                'map'      => $request->input('map'),
            ]);



            return response()->json(['message' => 'Cliente cadastrado com sucesso.', 'cliente' => $cliente], 202);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Erro verifique os campos'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro generalizado na operação'], 500);
        }
    
    }


    /**
     * Display the specified resource.
     */

    public function show($id)
    {
        try {
            $cliente = Cliente::findOrFail($id);

            return response()->json(['message' => 'Cliente encontrado com sucesso.', 'cliente' => $cliente], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Cliente não encontrado.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro generalizado na operação.'], 500);
        }
    }


    /**
     * Update the specified resource in storage.
     */

    public function update(UpdateClienteRequest $request, $id)
    {
        try {
            // Obter o cliente existente
            $cliente = Cliente::findOrFail($id);

            // Sanitizar o campo CPF para conter apenas números
            $cpf = preg_replace("/[^0-9]/", "", $request->input('cpf'));

            // Verificar dígitos verificadores
            if (!empty($cpf)) {
                // Verificar se o CPF já está cadastrado para outro cliente
                $existingCliente = Cliente::where('cpf', $cpf)->where('id', '!=', $id)->first();
                if ($existingCliente) {
                    return response()->json(['error' => "Erro: Este CPF já está cadastrado para outro cliente."], 422);
                }

                // Verificar se o CPF possui 11 dígitos ou mais
                if (strlen($cpf) < 11) {
                    return response()->json(['error' => 'Erro: O CPF está incompleto ou inválido.'], 501);
                }

                // Calcula o dígito verificador
                $soma = [0, 0];
                for ($i = 0; $i < 10; $i++) {
                    $soma[0] += $i < 9 ? $cpf[$i] * (10 - $i) : 0;
                    $soma[1] += $cpf[$i] * (11 - $i);
                }
                $DV1 = ($soma[0] % 11) > 1 ? 11 - ($soma[0] % 11) : 0;
                $DV2 = ($soma[1] % 11) > 1 ? 11 - ($soma[1] % 11) : 0;

                // Comparação do dígito com o CPF enviado
                if ($DV1 != $cpf[9] || $DV2 != $cpf[10]) {
                    return response()->json(['error' => 'Erro: CPF inválido.'], 422);
                }
            }

            // Verificar se o e-mail é um formato válido
            $validator = Validator::make($request->all(), [
                'email' => 'nullable|email',
            ])->fails();

            if ($validator) {
                return response()->json(['error' => 'Erro: O e-mail não está em um formato válido.'], 423);
            }

            // Verificar se o e-mail já está cadastrado para outro cliente
            $existingCliente = Cliente::where('email', $request->input('email'))->where('id', '!=', $id)->first();
            if ($existingCliente) {
                return response()->json(['error' => "Erro: Este e-mail já está cadastrado para outro cliente."], 423);
            }

            // Atualizar os dados do cliente
            $cliente->update([
                'nome' => $request->input('nome'),
                'cpf' => $cpf,
                'email' => $request->input('email'),
                'telefone' => $request->input('telefone'),
                'endereco' => $request->input('endereco'),
                'bairro' => $request->input('bairro'),
                'cidade' => $request->input('cidade'),
                'cep' => $request->input('cep'),
                'map' => $request->input('map'),
            ]);

            return response()->json(['message' => 'Cliente atualizado com sucesso.', 'cliente' => $cliente], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Erro: Cliente não encontrado.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro generalizado na operação.'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cliente $cliente)
    {
        //
    }
}
