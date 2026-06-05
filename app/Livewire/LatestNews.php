<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\HttpService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class LatestNews extends Component
{
    use AuthorizesRequests;

    public string $selectedCountry = '';
    public array $news = [];

    protected HttpService $httpService;

    public function boot(HttpService $httpService): void
    {
        $this->httpService = $httpService;
    }

    protected function rules(): array
    {
        return [
            'selectedCountry' => 'required|in:it,gb,us',
        ];
    }

    public function fetchNews(): void
    {
        $this->authorize('isWriter');

        $validated = $this->validate();
        $endpoints = $this->newsEndpoints();
        $country = $validated['selectedCountry'];

        if (! array_key_exists($country, $endpoints)) {
            $this->news = ['error' => 'Invalid country selection'];
            return;
        }

        $response = $this->httpService->getRequest($endpoints[$country]);
        $decoded = json_decode($response, true);

        if (! is_array($decoded) || ! isset($decoded['articles'])) {
            $this->news = ['error' => 'Unable to fetch news'];
            return;
        }

        $this->news = [
            'status' => $decoded['status'] ?? 'ok',
            'articles' => $decoded['articles'],
        ];
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