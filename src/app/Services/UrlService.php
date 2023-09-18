<?php

namespace App\Jobs;

use Illuminate\Support\Facades\Log;
use App\Models\Domain;
use App\Models\Url;
class UrlService {

    public function extractDomain () {
        $pieces = parse_url($this->url);
        $domain = isset($pieces['host']) ? $pieces['host'] : $pieces['path'];
        $domainModel = $this->getDomainModel($domain);
        $urlModel = $this->getUrlModel($this->url, $domainModel);
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
            $urlModel->domain()->associate($domainModel);
            $urlModel->save();
            return $urlModel;
        }
    }
}
