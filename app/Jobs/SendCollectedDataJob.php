<?php

namespace App\Jobs;

use App\Http\Controllers\UtilsController;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SendCollectedDataJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public string $url,
        public array $data = []
    )
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        UtilsController::exportToWebhookie($this->url, $this->data);
    }
}
