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

    public function avaliarAbdominais($idade, $sexo, $valor) {
        $criterios = [
            'M' => [ // Masculino
                6 => ['Fraco' => 18, 'Razoável' => 22, 'Bom' => 27, 'Muito Bom' => 38, 'Excelência' => 39],
                7 => ['Fraco' => 19, 'Razoável' => 24, 'Bom' => 29, 'Muito Bom' => 39, 'Excelência' => 40],
                8 => ['Fraco' => 20, 'Razoável' => 26, 'Bom' => 32, 'Muito Bom' => 40, 'Excelência' => 43],
                9 => ['Fraco' => 25, 'Razoável' => 30, 'Bom' => 35, 'Muito Bom' => 46, 'Excelência' => 48],
                10 => ['Fraco' => 27, 'Razoável' => 32, 'Bom' => 37, 'Muito Bom' => 46, 'Excelência' => 49],
                11 => ['Fraco' => 29, 'Razoável' => 34, 'Bom' => 39, 'Muito Bom' => 46, 'Excelência' => 50],
                12 => ['Fraco' => 30, 'Razoável' => 35, 'Bom' => 41, 'Muito Bom' => 48, 'Excelência' => 51],
                13 => ['Fraco' => 31, 'Razoável' => 37, 'Bom' => 43, 'Muito Bom' => 49, 'Excelência' => 52],
                14 => ['Fraco' => 32, 'Razoável' => 38, 'Bom' => 44, 'Muito Bom' => 50, 'Excelência' => 54],
                15 => ['Fraco' => 33, 'Razoável' => 39, 'Bom' => 45, 'Muito Bom' => 54, 'Excelência' => 60],
                16 => ['Fraco' => 36, 'Razoável' => 41, 'Bom' => 47, 'Muito Bom' => 60, 'Excelência' => 62],
                17 => ['Fraco' => 38, 'Razoável' => 42, 'Bom' => 49, 'Muito Bom' => 62, 'Excelência' => 63],
            ],
            'F' => [ // Feminino
                6 => ['Fraco' => 17, 'Razoável' => 21, 'Bom' => 26, 'Muito Bom' => 36, 'Excelência' => 37],
                7 => ['Fraco' => 19, 'Razoável' => 23, 'Bom' => 28, 'Muito Bom' => 39, 'Excelência' => 40],
                8 => ['Fraco' => 21, 'Razoável' => 26, 'Bom' => 31, 'Muito Bom' => 43, 'Excelência' => 45],
                9 => ['Fraco' => 23, 'Razoável' => 29, 'Bom' => 35, 'Muito Bom' => 45, 'Excelência' => 48],
                10 => ['Fraco' => 25, 'Razoável' => 30, 'Bom' => 35, 'Muito Bom' => 46, 'Excelência' => 49],
                11 => ['Fraco' => 26, 'Razoável' => 32, 'Bom' => 37, 'Muito Bom' => 46, 'Excelência' => 50],
                12 => ['Fraco' => 27, 'Razoável' => 34, 'Bom' => 39, 'Muito Bom' => 48, 'Excelência' => 51],
                13 => ['Fraco' => 28, 'Razoável' => 36, 'Bom' => 41, 'Muito Bom' => 49, 'Excelência' => 52],
                14 => ['Fraco' => 30, 'Razoável' => 38, 'Bom' => 44, 'Muito Bom' => 49, 'Excelência' => 54],
                15 => ['Fraco' => 31, 'Razoável' => 39, 'Bom' => 45, 'Muito Bom' => 49, 'Excelência' => 54],
                16 => ['Fraco' => 31, 'Razoável' => 40, 'Bom' => 46, 'Muito Bom' => 49, 'Excelência' => 54],
                17 => ['Fraco' => 32, 'Razoável' => 42, 'Bom' => 46, 'Muito Bom' => 49, 'Excelência' => 48],
            ]
        ];
    
        $faixa = $criterios[$sexo][$idade];
        
        if ($valor < $faixa['Fraco']) {
            return 'Fraco';
        } elseif ($valor <= $faixa['Razoável']) {
            return 'Razoável';
        } elseif ($valor <= $faixa['Bom']) {
            return 'Bom';
        } elseif ($valor <= $faixa['Muito Bom']) {
            return 'Muito Bom';
        } else {
            return 'Excelência';
        }
    }
    
}
