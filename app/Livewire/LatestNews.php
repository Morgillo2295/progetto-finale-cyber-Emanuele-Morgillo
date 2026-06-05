<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\HttpService;

class LatestNews extends Component
{
    public string $selectedCountry = '';

    public $news;

    protected HttpService $httpService;

    public function boot(HttpService $httpService): void
    {
        $this->httpService = $httpService;
    }

    public function fetchNews(): void
    {
        $endpoints = $this->newsEndpoints();

        if (! array_key_exists($this->selectedCountry, $endpoints)) {
            $this->news = ['error' => 'Invalid country selection'];

            return;
        }

        $response = $this->httpService->getRequest($endpoints[$this->selectedCountry]);
        $decoded = json_decode($response, true);

        if (! is_array($decoded)) {
            $this->news = ['error' => is_string($response) ? $response : 'Unable to fetch news'];

            return;
        }

        $this->news = $decoded;
    }

    protected function newsEndpoints(): array
    {
        $apiKey = config('services.newsapi.api_key', '');

        return [
            'it' => "https://newsapi.org/v2/top-headlines?country=it&apiKey={$apiKey}",
            'gb' => "https://newsapi.org/v2/top-headlines?country=gb&apiKey={$apiKey}",
            'us' => "https://newsapi.org/v2/top-headlines?country=us&apiKey={$apiKey}",
        ];
    }

    public function render()
    {
        return view('livewire.latest-news');
    }
}
