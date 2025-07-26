<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Despesa extends Model
{
    use HasFactory;

    protected $fillable = [
        'deputado_id',
        'ano',
        'mes',
        'tipo_despesa',
        'data_documento',
        'valor_documento',
        'url_documento',
    ];

    protected $casts = [
        'data_documento' => 'date',
        'valor_documento' => 'decimal:2',
    ];

    public function deputado()
    {
        return $this->belongsTo(Deputado::class);
    }
}
