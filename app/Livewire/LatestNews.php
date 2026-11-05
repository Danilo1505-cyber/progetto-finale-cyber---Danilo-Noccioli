<?php

namespace App\Livewire;

use GuzzleHttp\Client;
use Livewire\Component;
use App\Services\HttpService;

class LatestNews extends Component
{
    private const COUNTRY_ENDPOINTS = [
    'it' => 'https://newsapi.org/v2/top-headlines?country=it',
    'gb' => 'https://newsapi.org/v2/top-headlines?country=gb',
    'us' => 'https://newsapi.org/v2/top-headlines?country=us',
];
    public $selectedApi;
    public $news;
    protected $httpService;

    private const ALLOWED_HOSTS = ['newsapi.org', 'api.currentsapi.services'];

    public function __construct()
    {
        $this->httpService = app(HttpService::class);
    }

    public function fetchNews()
{
    // La chiave selezionata deve esistere nella mappa paesi consentiti
    if (!array_key_exists($this->selectedApi, self::COUNTRY_ENDPOINTS)) {
        $this->news = 'Paese non valido';
        return;
    }

    // URL costruito lato server, il client non lo controlla più
    $url = self::COUNTRY_ENDPOINTS[$this->selectedApi] . '&apiKey=' . config('services.newsapi.api_key');

    $host = parse_url($url, PHP_URL_HOST);

    // L'host deve essere nell'allowlist
    if (!in_array($host, self::ALLOWED_HOSTS, true)) {
        $this->news = 'Host non autorizzato';
        return;
    }

    // Protezione da DNS rebinding
    $ip = gethostbyname($host);
    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) === false) {
        $this->news = 'IP non autorizzato';
        return;
    }

    $this->news = $this->httpService->getRequest($url);
}

    public function render()
    {
        return view('livewire.latest-news');
    }
}