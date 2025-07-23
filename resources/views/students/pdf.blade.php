<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Desempenho do Aluno</title>
    <link rel="stylesheet" href="file:///{{ public_path('css/bootstrap.min.css') }}">
</head>
<body>
    @php
        $peso = isset($weight) && is_numeric($weight) ? number_format($weight, 2) . ' kg' : 'Peso não disponível';
        $altura = isset($height) && is_numeric($height) ? number_format($height, 2) . ' cm' : 'Altura não disponível';
        $imc = (isset($weight) && is_numeric($weight) && isset($height) && is_numeric($height) && $height > 0)
            ? number_format($weight / pow($height / 100, 2), 2)
            : 'Não disponível';
    @endphp

    <div class="container mt-4">
        <h2>Desempenho do Aluno</h2>
        <p><strong>Nome:</strong> {{ $student['name'] ?? 'Nome não disponível' }}</p>
        <!-- <p><strong>Peso:</strong> {{ $peso }}</p>
        <p><strong>Altura:</strong> {{ $altura }}</p>
        <p><strong>IMC:</strong> {{ $imc }}</p> -->

        <h3>Resultados</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Variável</th>
                    <th>Resultado</th>
                    <th>Classificação</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($resultados) && count($resultados) > 0)
                    @foreach ($resultados as $resultado)
                        <tr>
                            <td>{{ $resultado['variavel'] }}</td>
                            <td>{{ $resultado['resultado'] ?? 'N/A' }}</td>
                            @php
                                $cores = [
                                    'Excelente' => '#0d6efd',
                                    'Muito Bom' => '#0dcaf0',
                                    'Bom' => '#198754',
                                    'Razoável' => '#fd7e14',
                                    'Fraco' => '#dc3545',
                                ];

                                $classificacao = $resultado['classificacao']['classificacao'] ?? 'Não disponível';
                                $cor = $cores[$classificacao] ?? '#000000';
                            @endphp
                            <td style="color: {{ $cor }};">
                                {{ $classificacao }}
                            </td>

                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="3" class="text-center">Nenhum resultado disponível.</td>
                    </tr>
                @endif
            </tbody>
        </table>

        @if(isset($chartImages) && is_array($chartImages) && count($chartImages))
            <h3>Gráficos</h3>
            @foreach($chartImages as $img)
                <div style="margin-bottom: 20px;">
                    <img src="{{ $img }}" alt="Gráfico" style="max-width: 100%;">
                </div>
            @endforeach
        @endif
    </div>
</body>
</html>
