<?php

namespace App\Http\Controllers;

use App\Models\Deputado;
use App\Models\Despesa;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $query = Deputado::query();
        if ($request->filled('nome')) {
            $query->where('nome', 'like', '%' . $request->input('nome') . '%');
        }

        if ($request->filled('partido')) {
            $query->where('sigla_partido', 'like', '%' . $request->input('partido') . '%');
        }

        if ($request->filled('uf')) {
            $query->where('sigla_uf', 'like', '%' . $request->input('uf') . '%');
        }

        $deputados = $query->orderBy('nome')->get();
        return view('frontend.home', compact('deputados'));
    }

    public function despesas(Deputado $deputado)
    {
        $despesas = $deputado->despesas()->orderBy('data_documento', 'desc')->get();
        return view('frontend.despesas', compact('deputado', 'despesas'));
    }
}
