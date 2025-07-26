<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deputado extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_api',
        'nome',
        'sigla_partido',
        'sigla_uf',
        'url_foto',
        'email',
    ];

    /**
     * Define a relação com as Despesas.
     */
    public function despesas()
    {
        return $this->hasMany(Despesa::class);
    }

    /**
     * Define a relação com os Eventos.
     */
    // public function eventos()
    // {
    //     return $this->hasMany(Evento::class);
    // }
}
