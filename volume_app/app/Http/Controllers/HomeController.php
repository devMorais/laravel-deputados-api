<?php

namespace App\Http\Controllers;

use App\DataTables\DeputadoDataTable;
use App\Models\Deputado;

class HomeController extends Controller
{

    public function index(DeputadoDataTable $dataTable)
    {
        return $dataTable->render('frontend.home');
    }

    public function despesas(Deputado $deputado)
    {
        $despesas = $deputado->despesas()->orderBy('data_documento', 'desc')->get();
        return view('frontend.despesas', compact('deputado', 'despesas'));
    }
}
