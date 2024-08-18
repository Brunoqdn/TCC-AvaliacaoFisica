<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medida extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'idade',
        'sexo',
        'peso',
        'altura',
        'flexibilidade',
        'abdominais',
        'corrida6min',
        'medicineBall',
        'saltoHorizontal',
        'quadrado',
        'corrida20m',
    ];
}
