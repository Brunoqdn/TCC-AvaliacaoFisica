<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Illuminate\Support\Facades\Log;

class PdfController extends Controller
{
    public function gerarPDF(Request $request)
    {
        try {
            $studentData = json_decode($request->input('student'), true);
            $weight = is_numeric($studentData['weight'] ?? null) ? floatval($studentData['weight']) : null;
            $height = is_numeric($studentData['height'] ?? null) ? floatval($studentData['height']) : null;


            $data = [
                'student' => $studentData,
                'resultados' => json_decode($request->input('resultados'), true),
                'chartImages' => json_decode($request->input('chart_image'), true),
                'weight' => $weight,
                'height' => $height,
            ];


            $pdf = SnappyPdf::loadView('students.pdf', $data);

            // Adiciona opções para evitar erros com arquivos locais e codificação
            $pdf->setOption('enable-local-file-access', true);
            $pdf->setOption('encoding', 'utf-8');

            return $pdf->download('desempenho-aluno.pdf');
        } catch (\Throwable $e) {
            Log::error('Erro ao gerar PDF:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json(['error' => 'Erro ao gerar PDF. Consulte os logs.'], 500);
        }
    }
}
