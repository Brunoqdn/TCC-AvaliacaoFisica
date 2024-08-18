<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medida;
use Illuminate\Support\Facades\Log; // Adicione esta linha

class MedidaController extends Controller
{
    public function pesquisar(Request $request)
    {
        $nome = $request->query('nome');
        $pessoas = Medida::where('nome', 'LIKE', "%$nome%")->get();
        return response()->json($pessoas);
    }
    


    public function store(Request $request)
    {
        // Validação dos dados recebidos
        $request->validate([
            'nome' => 'required|string|max:255',
            'idade' => 'required|integer',
            'sexo' => 'required|string|max:1',
            'peso' => 'required|numeric|min:0',
            'altura' => 'required|numeric|min:0',
            'flexibilidade' => 'required|numeric|min:0',
            'abdominais' => 'required|integer|min:0',
            'corrida6min' => 'required|integer|min:0',
            'medicineBall' => 'required|integer|min:0',
            'saltoHorizontal' => 'required|integer|min:0',
            'quadrado' => 'required|numeric|min:0',
            'corrida20m' => 'required|numeric|min:0',
        ]);
        
        // Log dos dados recebidos para depuração
        Log::info('Dados Recebidos para Inserção:', $request->all());

        // Tente criar a nova medida no banco de dados
        try {
            $medida = Medida::create($request->all());

            // Log do sucesso na criação
        Log::info('Medida criada com sucesso:', $medida->toArray());

            // Retorna uma resposta de sucesso
            return response()->json(['success' => true, 'message' => 'Medida salva com sucesso!']);
        } catch (\Exception$e) {
            // Registra o erro no log do Laravel para depuração
            Log::error('Erro ao salvar a medida: ' . $e->getMessage());

            // Retorna uma resposta de erro com a mensagem da exceção
            return response()->json(['success' => false, 'message' => 'Erro ao salvar os dados.', 'error' => $e->getMessage()], 500);
        }
    }
}