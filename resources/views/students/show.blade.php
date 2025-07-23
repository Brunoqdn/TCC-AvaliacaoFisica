<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Desempenho do Aluno: {{ $student->name }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<meta name="csrf-token" content="{{ csrf_token() }}">
<body class="d-flex flex-column min-vh-100 bg-light">

<nav class="navbar navbar-expand-lg bg-primary-color border-bottom" id="navbar">
    <div class="container py-3 d-flex justify-content-between align-items-center">
        <a href="{{ route('home') }}" class="navbar-brand primary-color d-flex align-items-center">
            <img src="{{ asset('img/tcc-icon.png') }}" alt="TCC" style="height: 40px;">
            <span class="ms-2">TCC</span>
        </a>
        <div>
            <a href="{{ route('dashboard') }}" class="btn btn-sm btn-outline-dark me-2">Voltar</a>
            <button type="button" onclick="submeterFormularioPDF()" class="btn btn-sm btn-warning">Gerar PDF</button>
            <form id="pdfForm" action="{{ route('generate.pdf') }}" method="POST" target="_blank" style="display:none;">
                @csrf
                <input type="hidden" name="student" id="student_input">
                <input type="hidden" name="resultados" id="resultados_input">
                <input type="hidden" name="chart_image" id="chart_image_input">
            </form>
        </div>
    </div>
</nav>

<main class="container my-5">
    <h2 class="text-center mb-4 primary-color">Desempenho do Aluno: <strong>{{ $student->name }}</strong></h2>
    @php
        $peso = isset($student['weight']) && is_numeric($student['weight']) ? $student['weight'] : (isset($weight) && is_numeric($weight) ? $weight : null);
        $altura = isset($student['height']) && is_numeric($student['height']) ? $student['height'] : (isset($height) && is_numeric($height) ? $height : null);
        $imc = ($peso && $altura && $altura != 0) ? number_format($peso / pow($altura / 100, 2), 2) : 'Não disponível';
    @endphp

    <h5 class="text-center mb-3 secondary-color">Massa Corporal (kg): <strong>{{ $peso }}</strong></h5>
    <h5 class="text-center mb-3 secondary-color">Estatura (cm): <strong>{{ $altura }}</strong></h5>
    <h5 class="text-center mb-4 secondary-color">IMC: <strong class="primary-color">{{ $imc }}</strong></h5>

    <section class="mb-5">
        <h4 class="primary-color">Resultados</h4>
        <table class="table table-striped table-hover">
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
                            <td>{{ $resultado['resultado'] ?? 'Não disponível' }}</td>
                            <td class="{{ $resultado['classificacao']['classificacao_cor'] }}">
                                {{ $resultado['classificacao']['classificacao'] }}
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
    </section>

    <div id="graficos-container" class="row gy-4"></div>
</main>

<footer class="mt-auto bg-dark text-white py-3">
    <div class="container text-center">
        <small>&copy; 2024 Projeto TCC. Todos os direitos reservados.</small>
    </div>
</footer>

<script>
    function gerarGrafico() {
        const studentId = "{{ $student->id }}";
        const url = `/api/performance/student/${studentId}/all`;
        const exercicioMapping = {
            'abdominals': 'abdominais',
            'flexibility': 'flexibilidade',
            'run_6min': 'corrida_6min',
            'medicine_ball': 'medicine_ball',
            'horizontal_jump': 'salto_horizontal',
            'square_run': 'corrida_no_quadrado',
            'run_20m': 'corrida_20_metros'
        };

        fetch(url)
            .then(response => response.ok ? response.json() : Promise.reject("Erro na API"))
            .then(data => {
                if (!data?.percentis || !data?.desempenho) return;
                Object.entries(exercicioMapping).forEach(([key, apiKey]) => {
                    const percentis = data.percentis[apiKey];
                    if (!percentis) return;

                    const labels = percentis.map(p => p.idade);
                    const datasets = [
                        { label: 'Fraco', data: percentis.map(p => p.percentil_fraco), borderColor: 'red', fill: false },
                        { label: 'Razoável', data: percentis.map(p => p.percentil_razoavel), borderColor: 'orange', fill: false },
                        { label: 'Bom', data: percentis.map(p => p.percentil_bom), borderColor: 'green', fill: false },
                        { label: 'Muito Bom', data: percentis.map(p => p.percentil_muito_bom), borderColor: 'lightblue', fill: false },
                        { label: 'Excelente', data: percentis.map(p => p.percentil_excelente), borderColor: 'blue', fill: false },
                        {
                            label: 'Desempenho do Aluno',
                            data: data.desempenho.map(test => ({ x: parseFloat(test.age), y: test[key] || 0 })),
                            borderColor: 'purple', backgroundColor: 'purple', pointRadius: 5, showLine: false
                        }
                    ];

                    const canvas = document.createElement('canvas');
                    canvas.className = "col-12 col-md-6 mb-4";
                    document.getElementById('graficos-container').appendChild(canvas);

                    new Chart(canvas, {
                        type: 'line',
                        data: { labels, datasets },
                        options: {
                            responsive: true,
                            plugins: { title: { display: true, text: `Desempenho - ${apiKey}` } },
                            scales: {
                                x: { title: { display: true, text: 'Idade (Anos)' } },
                                y: { title: { display: true, text: 'Percentil' }, beginAtZero: true }
                            }
                        }
                    });
                });
            })
            .catch(console.error);
    }

    gerarGrafico();

    function submeterFormularioPDF() {
        const charts = document.querySelectorAll('#graficos-container canvas');
        const chartImages = Array.from(charts).map(c => c.toDataURL('image/png'));

        const student = {
            name: "{{ $student->name }}",
            weight: "{{ $student->weight ?? '' }}",

            height: {{ $student->height ?? 'null' }}
        };

        const resultados = {!! json_encode($resultados ?? []) !!};

        document.getElementById('student_input').value = JSON.stringify(student);
        document.getElementById('resultados_input').value = JSON.stringify(resultados);
        document.getElementById('chart_image_input').value = JSON.stringify(chartImages);

        document.getElementById('pdfForm').submit();
    }
</script>
 
</body>
</html>