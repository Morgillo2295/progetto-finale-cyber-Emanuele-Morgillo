<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Auth;

class HttpService
{
    protected Client $client;

    protected array $allowedDomains = ['internal.finance', 'newsapi.org'];

    protected array $allowedProtocols = ['http', 'https'];

    protected string $refererHeader;

    public function __construct()
    {
        $this->refererHeader = config('app.url');
        $this->client = new Client([
            'allow_redirects' => false,
            'timeout' => 10,
        ]);
    }

    public function getRequest(string $url, bool $allowInternalFinance = false): string
    {
        $parsedUrl = parse_url($url);

        if (! is_array($parsedUrl) || empty($parsedUrl['scheme']) || empty($parsedUrl['host'])) {
            return 'Invalid URL';
        }

        if (! in_array($parsedUrl['scheme'], $this->allowedProtocols, true)) {
            return 'Protocol not allowed';
        }

        $host = strtolower($parsedUrl['host']);

        if (! in_array($host, $this->allowedDomains, true)) {
            return 'Domain not allowed';
        }

        if ($host === 'internal.finance' && ! $allowInternalFinance) {
            return 'Access to internal finance data is restricted to administrators';
        }

        if ($host === 'internal.finance' && (! Auth::check() || ! Auth::user()->is_admin)) {
            return 'Access to internal finance data is restricted to administrators';
        }

        $options = [
            'headers' => ['Referer' => $this->refererHeader],
        ];

        try {
            $response = $this->client->request('GET', $url, $options);

            return $response->getBody()->getContents();
        } catch (RequestException $e) {
            return 'Something went wrong: '.$e->getMessage();
        }
    }
}
