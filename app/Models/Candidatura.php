<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Candidatura extends Model
{
    protected $fillable = [
        'nome','email','telefone','cargo_desejado','escolaridade',
        'observacoes','arquivo_path','ip','enviado_em',
    ];

    protected $casts = [
        'enviado_em' => 'datetime',
    ];
}
