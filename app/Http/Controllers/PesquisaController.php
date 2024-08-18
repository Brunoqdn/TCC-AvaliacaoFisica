<?php
namespace App\Http\Controllers;

use App\Models\Medida;
use Illuminate\Http\Request;


class PesquisaController extends Controller
{
    public function pesquisar(Request $request)
    {
        $nome = $request->query('nome');
        $resultados = Medida::where('nome', 'like', "%$nome%")->get();
        return response()->json($resultados);
    }

    public function percentis($id)
    {
        $pessoa = Medida::find($id);
        // Lógica para calcular os percentis de acordo com os dados zipados
        $percentis = [
            'flexibilidade' => 'Zona X',
            'abdominais' => 'Zona Y',
            // Complete com os demais exercícios
        ];
        return response()->json($percentis);
    }
}
