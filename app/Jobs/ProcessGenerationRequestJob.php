<?php

namespace App\Jobs;

use App\Services\GenerationOrchestrator;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ProcessGenerationRequestJob implements ShouldQueue
{
    use Queueable;

    public int $tries = 3;

    /**
     * Create a new job instance.
     */
    public function __construct(public readonly int $generationRequestId) {}

    /**
     * Execute the job.
     */
    public function handle(GenerationOrchestrator $orchestrator): void
    {
        $orchestrator->processById($this->generationRequestId);
    }
}
