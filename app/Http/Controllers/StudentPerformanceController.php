<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Percentis;

class StudentPerformanceController extends Controller
{
    public function show($studentId)
{
    $student = Student::find($studentId);

    if (!$student) {
        return redirect()->back()->with('error', 'Aluno não encontrado.');
    }

    // Obtemos o teste mais recente do aluno
    $latestTest = $student->tests()->latest('test_date')->first();

    if (!$latestTest) {
        return redirect()->back()->with('error', 'Nenhum teste disponível para o aluno.');
    }

    // Obter percentis agrupados por tipo de exercício
    $percentis = Percentis::where('sexo', $student->gender)->get()->groupBy('tipo_exercicio');

    // Mapeamento para resultados
    $resultados = [
        [
            'variavel' => 'Flexibilidade',
            'resultado' => $latestTest->flexibility,
            'classificacao' => $this->getClassificacao($percentis['flexibilidade'], $latestTest->flexibility),
        ],
        [
            'variavel' => 'Força Abdominal',
            'resultado' => $latestTest->abdominals,
            'classificacao' => $this->getClassificacao($percentis['abdominais'], $latestTest->abdominals),
        ],
        [
            'variavel' => 'VO2 Máximo',
            'resultado' => $latestTest->run_6min, // Ajuste conforme a métrica desejada
            'classificacao' => $this->getClassificacao($percentis['corrida_6min'], $latestTest->run_6min),
        ],
        // Adicione outras variáveis de desempenho aqui
    ];

    return view('students.show', compact('student', 'resultados'));
}

/**
 * Determina a classificação com base nos percentis
 */
private function getClassificacao($percentis, $valor)
{
    foreach ($percentis as $p) {
        if ($valor < $p->percentil_fraco) {
            return ['classificacao' => 'Fraco', 'classificacao_cor' => 'text-danger'];
        } elseif ($valor < $p->percentil_razoavel) {
            return ['classificacao' => 'Razoável', 'classificacao_cor' => 'text-warning'];
        } elseif ($valor < $p->percentil_bom) {
            return ['classificacao' => 'Bom', 'classificacao_cor' => 'text-primary'];
        } elseif ($valor < $p->percentil_muito_bom) {
            return ['classificacao' => 'Muito Bom', 'classificacao_cor' => 'text-success'];
        }
    }

    return ['classificacao' => 'Excelente', 'classificacao_cor' => 'text-success'];
}

    public function showPerformance($id)
    {
        // Buscar o estudante específico
        $student = Student::findOrFail($id);

        // Funções de avaliação
        $student->flexibilidadeAvaliacao = $this->avaliarFlexibilidade($student);
        $student->abdominaisAvaliacao = $this->avaliarAbdominais($student);
        $student->corrida6minAvaliacao = $this->avaliarCorrida6Min($student);
        $student->medicineBallAvaliacao = $this->avaliarMedicineBall($student);
        $student->saltoHorizontalAvaliacao = $this->avaliarSaltoHorizontal($student);
        $student->quadradoAvaliacao = $this->avaliarQuadrado($student);
        $student->corrida20mAvaliacao = $this->avaliarCorrida20m($student);

        // Retornar o estudante com avaliações para a view ou JSON
        return response()->json($student);
    }

    // Função de avaliação de Flexibilidade
    private function avaliarFlexibilidade($student)
    {
        $idade = $student->idade;
        $sexo = $student->sexo;
        $flexibilidade = $student->flexibilidade;

        if ($sexo === 'M') {
            if ($idade === 6) {
                if ($flexibilidade < 34.3) return 'Fraco';
                if ($flexibilidade < 41.3) return 'Razoável';
                if ($flexibilidade < 50.4) return 'Bom';
                if ($flexibilidade < 74.0) return 'Muito Bom';
                return 'Excelência';
            } elseif ($idade === 7) {
                if ($flexibilidade < 33.3) return 'Fraco';
                if ($flexibilidade < 39.7) return 'Razoável';
                if ($flexibilidade < 48.0) return 'Bom';
                if ($flexibilidade < 68.5) return 'Muito Bom';
                return 'Excelência';
            }
            // Continue as faixas etárias de acordo com os dados...
        } elseif ($sexo === 'F') {
            if ($idade === 6) {
                if ($flexibilidade < 37.0) return 'Fraco';
                if ($flexibilidade < 43.9) return 'Razoável';
                if ($flexibilidade < 52.6) return 'Bom';
                if ($flexibilidade < 73.4) return 'Muito Bom';
                return 'Excelência';
            } elseif ($idade === 7) {
                if ($flexibilidade < 35.3) return 'Fraco';
                if ($flexibilidade < 41.9) return 'Razoável';
                if ($flexibilidade < 50.0) return 'Bom';
                if ($flexibilidade < 69.1) return 'Muito Bom';
                return 'Excelência';
            }
            // Continue as faixas etárias de acordo com os dados...
        }

        return 'N/A';
    }

    // Função de avaliação de Abdominais
    private function avaliarAbdominais($student)
    {
        $idade = $student->idade;
        $sexo = $student->sexo;
        $abdominais = $student->abdominais;

        if ($sexo === 'M') {
            if ($idade <= 6) {
                if ($abdominais < 18) return 'Fraco';
                if ($abdominais < 23) return 'Razoável';
                if ($abdominais < 28) return 'Bom';
                if ($abdominais < 39) return 'Muito Bom';
                return 'Excelência';
            }
            // Continue as faixas etárias de acordo com os dados...
        } elseif ($sexo === 'F') {
            if ($idade <= 6) {
                if ($abdominais < 17) return 'Fraco';
                if ($abdominais < 22) return 'Razoável';
                if ($abdominais < 27) return 'Bom';
                if ($abdominais < 37) return 'Muito Bom';
                return 'Excelência';
            }
            // Continue as faixas etárias de acordo com os dados...
        }

        return 'N/A';
    }

    // Função de avaliação de Corrida de 6 Minutos
    private function avaliarCorrida6Min($student)
    {
        $idade = $student->idade;
        $sexo = $student->sexo;
        $corrida6min = $student->corrida6min;

        if ($sexo === 'M') {
            if ($idade === 6) {
                if ($corrida6min < 730) return 'Fraco';
                if ($corrida6min < 826) return 'Razoável';
                if ($corrida6min < 957) return 'Bom';
                if ($corrida6min < 1317) return 'Muito Bom';
                return 'Excelência';
            }
            // Continue as faixas etárias de acordo com os dados...
        } elseif ($sexo === 'F') {
            if ($idade === 6) {
                if ($corrida6min < 672) return 'Fraco';
                if ($corrida6min < 768) return 'Razoável';
                if ($corrida6min < 901) return 'Bom';
                if ($corrida6min < 1277) return 'Muito Bom';
                return 'Excelência';
            }
            // Continue as faixas etárias de acordo com os dados...
        }

        return 'N/A';
    }

    // Continue com as outras funções de avaliação: avaliarMedicineBall, avaliarSaltoHorizontal, avaliarQuadrado, avaliarCorrida20m.
    // Para cada função, copie e adapte os critérios com base nas idades e valores de avaliação.

    // Exemplo de esqueleto para a próxima função
    private function avaliarMedicineBall($student)
    {
        // Adicione a lógica aqui conforme os critérios de avaliação de Medicine Ball
        return 'N/A';
    }

    private function avaliarSaltoHorizontal($student)
    {
        // Adicione a lógica aqui conforme os critérios de avaliação de Salto Horizontal
        return 'N/A';
    }

    private function avaliarQuadrado($student)
    {
        // Adicione a lógica aqui conforme os critérios de avaliação de Quadrado
        return 'N/A';
    }

    private function avaliarCorrida20m($student)
    {
        // Adicione a lógica aqui conforme os critérios de avaliação de Corrida de 20 metros
        return 'N/A';
    }
}
