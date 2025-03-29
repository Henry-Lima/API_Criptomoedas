<?php

namespace App\Http\Controllers;

use App\Models\ApiCripto;
use Illuminate\Http\Request;    

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class ApiCriptoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Buscando todas as criptomoedas
        $registros = ApiCripto::All();

        //Contando o número de registros
        $contador = $registros->count();

        //Verificando se há registros
        if($contador > 0) {
            return response()->json([
            'success' => true,
            'message' => 'Criptomoedas encontradas com sucesso!',
            'data' => $registros,
            'total' => $contador
            ], 200); 
        }else {
            return response()->json([
                'sucess' => false,
                'message' => 'Nenhuma criptomoeda encontrada.',
            ], 404);
        };
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //Validação dos dados recebidos
      $validator = Validator::make($request->all(), [
        'sigla' => 'required',
        'nome' => 'required',
        'valor'=> 'required'
      ]);

      if($validator->fails()) {
        return response()->json([
            'success' => false,
            'message' => 'Registros inválidos',
            'errors' => $validator->errors()
        ], 400);
      }

      $registros = ApiCripto::create($request->all());

      if($registros) {
        return response()->json([
            'success' => true,
            'message' => 'Criptomoeda cadastrada com sucesso!',
            'data' => $registros
        ], 201);
      } else {
        return response()->json([
            'success' => false,
            'message' => 'Error ao cadastrar a criptomoeda'
        ], 500);
      }
    }

    /**
     * Display the specified resource.
     */
    public function show( $id)
    {
        //Busando a criptomoeda pelo ID
        $registros = ApiCripto::find($id);

        //Verificando se a criptomoeda foi encontrada
        if($registros){
            return 'Criptomoedas Localizadas: '.$registros.Response()->json([
                'sucess' => true,
                'message' => 'Criptomoeda localizada com sucesso!',
                'data' => $registros
            ]);   
        }
        else{
            return response()->json([
                'sucess' => false,
                'message' => 'Criptomoeda não localizada!'
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'sigla' => 'required',
            'nome' => 'required',
            'valor' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Registros inválidos',
                'errors' => $validator->errors()
            ], 400);
        }

        //Encontrando a criptomoeda no banco
        $registrosBanco = ApiCripto::find($id);

        if (!$registrosBanco) {
            return response()->json([
                'success' => false,
                'message' => 'Criptomoeda não encontrado'
            ], 404);
        }

        //Atualizando os dados
        $registrosBanco->sigla = $request->sigla;
        $registrosBanco->nome = $request->nome;
        $registrosBanco->valor = $request->valor;

        //Salvando as alterações
        if ($registrosBanco->save()) {
            return response()->json([
                'success' => true,
                'message' => 'Criptomoeda atualizado com sucesso!',
                'data' => $registrosBanco
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao atualizar a criptomoeda'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $registros = ApiCripto::find($id);

        if(!$registros) {
            return response()->json([
                'success' => false,     
                'message' => 'criptomoeda não encontradp'
            ], 404);
        }

        if ($registros->delete()) {
            return response()->json([
                'success' => true,
                'message' => 'Criptomoeda deletado com sucesso'
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Erro ao deletar a criptomoeda'
        ], 500);
    }
}
