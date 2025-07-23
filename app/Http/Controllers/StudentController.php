<?php

// app/Http/Controllers/StudentController.php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
{
    $students = Student::all(); // ou qualquer outra lógica para buscar os alunos
    return view('students.index', compact('students'));
}


public function show(Student $student)
{
    // Carrega o relacionamento com os testes ordenando pela data (mais recente primeiro)
    $latestTest = $student->tests()->orderByDesc('test_date')->first();

    $weight = $latestTest?->weight;
    $height = $latestTest?->height;

    return view('students.show', compact('student', 'weight', 'height'));
}

public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'gender' => 'required|string|max:1',
        'birth_date' => 'required|date', // Validando birth_date
    ]);

    Student::create([
        'name' => $request->name,
        'gender' => $request->gender,
        'birth_date' => $request->birth_date, // Salvando birth_date
    ]);

    return redirect()->route('students.index')->with('success', 'Aluno adicionado com sucesso.');
}

}