<?php

namespace App\DataTables;

use App\Models\Deputado;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button; // Importe o Button
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class DeputadoDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('url_foto', function ($deputado) {
                $imageUrl = $deputado->url_foto ? $deputado->url_foto : 'https://placehold.co/50x50/cccccc/333333?text=N/A';
                return '<img src="' . $imageUrl . '" alt="Foto de ' . $deputado->nome . '" class="img-thumbnail rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">';
            })
            ->addColumn('action', function ($deputado) {
                return '<div class="btn-group" role="group" aria-label="Ações">
                            <a href="' . route('despesas', $deputado->id) . '" class="btn btn-sm btn-secondary mt-1">
                                <i class="bi bi-cash-stack me-1"></i> Ver Despesas
                            </a>
                        </div>';
            })
            ->rawColumns(['url_foto', 'action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Deputado $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('deputado-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(0)
            ->pageLength(20)
            ->lengthMenu([10, 20, 50, 100])
            ->lengthChange(true)
            ->language([
                'sProcessing' => 'Processando...',
                'sLengthMenu' => 'Mostrar _MENU_ registros',
                'sZeroRecords' => 'Nenhum registro encontrado',
                'sInfo' => 'Mostrando de _START_ até _END_ de _TOTAL_ entradas',
                'sInfoEmpty' => 'Mostrando 0 até 0 de 0 entradas',
                'sInfoFiltered' => '(filtrado de _MAX_ entradas totais)',
                'sSearch' => 'Pesquisar:',
                'sEmptyTable' => 'Nenhum dado disponível na tabela',
                'sLoadingRecords' => 'Carregando...',
                'sFirst' => 'Primeiro',
                'sLast' => 'Último',
                'sNext' => 'Próximo',
                'sPrevious' => 'Anterior',
                'oPaginate' => [
                    'sFirst' => 'Primeiro',
                    'sLast' => 'Último',
                    'sNext' => 'Próximo',
                    'sPrevious' => 'Anterior',
                ],
                'oAria' => [
                    'sSortAscending' => ': Ative para ordenar a coluna de forma ascendente',
                    'sSortDescending' => ': Ative para ordenar a coluna de forma descendente',
                ],
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('url_foto')
                ->title('Foto')
                ->orderable(false)
                ->searchable(false)
                ->width(70)
                ->addClass('text-center align-middle'),
            Column::make('nome')
                ->width(150)
                ->addClass('text-start align-middle'),
            Column::make('sigla_partido')
                ->width(80)
                ->title('Partido')
                ->addClass('text-center align-middle'),
            Column::make('sigla_uf')
                ->width(50)
                ->title('UF')
                ->addClass('text-center align-middle'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(120)
                ->addClass('text-center align-middle')
                ->title('Ações')
                ->orderable(false)
                ->searchable(false),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Deputado_' . date('YmdHis');
    }
}
