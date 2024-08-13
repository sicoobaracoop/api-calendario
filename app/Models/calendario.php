<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class calendario extends Model
{
    use HasFactory;
    protected $fillable = [
        'mes',
        'tipo',
        'horarios',
        'descricao',
        'data',
        'periodo',
        'empresaId',
    ];

    public function empresa() {
        return $this->belongsTo(empresas::class, 'empresaId');
    }
}
