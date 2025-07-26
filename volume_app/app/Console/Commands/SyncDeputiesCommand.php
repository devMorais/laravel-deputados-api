<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Jobs\SyncDeputyExpensesJob;
// use App\Jobs\SyncDeputyEventsJob;
use App\Models\Deputado;

class SyncDeputiesCommand extends Command
{
    /**
     * O nome e a assinatura do comando do console.
     *
     * @var string
     */
    protected $signature = 'sync:deputies';

    /**
     * A descrição do comando do console.
     *
     * @var string
     */
    protected $description = 'Sincroniza a lista de deputados e despacha jobs para sincronizar despesas e eventos.';

    /**
     * Executa o comando.
     */
    public function handle(): void
    {
        $this->info('Iniciando sincronização de deputados...');

        try {
            $response = Http::get('https://dadosabertos.camara.leg.br/api/v2/deputados');
            $response->throw();
            $deputies = $response->json()['dados'];

            foreach ($deputies as $deputyData) {
                $deputado = Deputado::updateOrCreate(
                    ['id_api' => $deputyData['id']],
                    [
                        'nome' => $deputyData['nome'],
                        'sigla_partido' => $deputyData['siglaPartido'],
                        'sigla_uf' => $deputyData['siglaUf'],
                        'url_foto' => $deputyData['urlFoto'],
                    ]
                );

                SyncDeputyExpensesJob::dispatch($deputado->id_api);
                $this->line("Despachado job para despesas do deputado ID: {$deputado->id_api}");
            }

            $this->info('Sincronização de deputados, despesas e eventos concluída. Jobs despachados.');
        } catch (\Exception $e) {
            $this->error('Erro ao sincronizar deputados: ' . $e->getMessage());
        }
    }
}
