<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use App\Models\Domain;
use App\Models\Url;

class ProcessUrl implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $urls;
    /**
     * Create a new job instance.
     */
    public function __construct($urls)
    {
        $this->urls = $urls;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        foreach($this->urls as $url) {
            StoreUrl::dispatch($url);
        }
    }
}
