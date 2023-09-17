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

class StoreUrl implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $url;
    /**
     * Create a new job instance.
     */
    public function __construct($url)
    {
        $this->url = $url;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $pieces = parse_url($this->url);
        $domain = isset($pieces['host']) ? $pieces['host'] : $pieces['path'];
        $domainModel = $this->getDomainModel($domain);
        $urlModel = $this->getUrlModel($this->url, $domainModel);
        Log::info(json_encode($urlModel));
    }

    public function getDomainModel($domain) {
        $existingDomain = Domain::where('name', $domain)->first();
        if($existingDomain) {
            return $existingDomain;
        } else {
            $domainModel = new Domain();
            $domainModel->name = $domain;
            $domainModel->save();
            return $domainModel;
        }

    }

    public function getUrlModel($url, $domainModel) {
        $existingUrl = Url::where('url', $url)->first();
        if($existingUrl) {
            return $existingUrl;
        } else {
            $urlModel = new Url();
            $urlModel->url = $url;
            $urlModel->save();
            $domainModel->urls()->save();
            return $urlModel;
        }

    }
}
