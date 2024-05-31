<?php
// app/Services/TMDBService.php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class TMDBService
{
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = config('services.tmdb.api_key');
    }

    public function fetchMovieDetails($movieId)
    {
        return Cache::remember("movie:{$movieId}:details", 3600, function () use ($movieId) {
            $response = Http::get("https://api.themoviedb.org/3/movie/{$movieId}", [
                'api_key' => $this->apiKey
            ]);
            return $response->json();
        });

    }
}
