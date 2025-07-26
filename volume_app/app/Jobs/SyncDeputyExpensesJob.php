<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Deputado;
use App\Models\Despesa;

class SyncDeputyExpensesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $deputadoApiId;

    /**
     * Cria uma nova instância do job.
     */
    public function __construct(int $deputadoApiId)
    {
        $this->deputadoApiId = $deputadoApiId;
    }

    /**
     * Executa o job.
     */
    public function handle(): void
    {
        try {
            $deputado = Deputado::where('id_api', $this->deputadoApiId)->first();

            if (!$deputado) {
                Log::error("Job SyncDeputyExpensesJob: Deputado com ID {$this->deputadoApiId} não encontrado na base de dados local.");
                $this->fail(new \Exception("Deputado com ID {$this->deputadoApiId} não encontrado na base de dados local."));
                return;
            }

            Log::info("Sincronizando despesas para o deputado ID: {$this->deputadoApiId}");

            $response = Http::get("https://dadosabertos.camara.leg.br/api/v2/deputados/{$this->deputadoApiId}/despesas");
            $response->throw();

            $expenses = $response->json()['dados'];

            foreach ($expenses as $expenseData) {
                Despesa::firstOrCreate(
                    [
                        'deputado_id' => $deputado->id,
                        'data_documento' => $expenseData['dataDocumento'],
                        'tipo_despesa' => $expenseData['tipoDespesa'],
                        'valor_documento' => $expenseData['valorDocumento'],
                    ],
                    [
                        'ano' => $expenseData['ano'],
                        'mes' => $expenseData['mes'],
                        'url_documento' => $expenseData['urlDocumento'] ?? null,
                    ]
                );
            }

            Log::info("Despesas do deputado ID: {$this->deputadoApiId} sincronizadas com sucesso.");
        } catch (\Exception $e) {
            Log::error("Job SyncDeputyExpensesJob: Erro ao sincronizar despesas do deputado ID {$this->deputadoApiId}: " . $e->getMessage());
            $this->fail($e);
        }
    }

    /**
     * Lida com a falha de um job.
     */
    public function failed(?\Throwable $exception): void
    {
        Log::error("Job SyncDeputyExpensesJob falhou para o deputado ID {$this->deputadoApiId}. Erro: " . $exception->getMessage());
    }
}
