<?php

namespace App\Http\Controllers\Api\V001;

use App\Models\Movie;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\V001\Requests\StoreMovieRequest;
use App\Http\Controllers\Api\V001\Requests\UpdateMovieRequest;
use App\Http\Controllers\Api\V001\Requests\SerachMovieRequest;
use App\Http\Controllers\Api\V001\Requests\ShowMovieRequest;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class MovieController extends ApiController
{
    public function index(SerachMovieRequest $request)
    {
        $perPage = $this->perPage($request);
        $movies = Movie::query()
        ->search($request->search)
        ->genre($request->genre)
        ->paginate($perPage);

        return $this->jsonResponse(200, 'Data Returned Successfully', null, $movies);
    }

    public function show(ShowMovieRequest $request,$id)
    {
        $movie = Movie::findOrFail($id);
        return $this->jsonResponse(200, 'Data Returned Successfully', null, $movie);
    }

    public function store(StoreMovieRequest $request)
    {
        $movie = Movie::create($request->validated());
        return $this->jsonResponse(200, 'Data Stored Successfully', null, $movie);
    }

    public function update(UpdateMovieRequest $request, $id)
    {
        $movie = Movie::findOrFail($id);
        $movie->update($request->validated());
        return $this->jsonResponse(200, 'Data Updated Successfully', null, $movie);
    }

    public function destroy(ShowMovieRequest $request,$id)
    {
        Movie::destroy($id);
        return $this->jsonResponse(200, 'Data Destroyed Successfully', null, null);
    }

    public function favorite(ShowMovieRequest $request,$id)
    {

        $movie = Movie::findOrFail($id);
        $movie->is_favorite = true;

        try {
            // Fetch additional data from TMDB
            $client = new Client();
        
            $response = $client->get('https://api.themoviedb.org/3/movie/' . $movie->pos, [
                'query' => [
                    'api_key' => env('TMDB_API_KEY')
                ]
            ]);
             
            $tmdbData = json_decode($response->getBody()->getContents(), true);

            // Save additional TMDB data to the movie record
            $movie->tmdb_rating = $tmdbData['vote_average'];
            $movie->tmdb_votes = $tmdbData['vote_count'];
            $movie->tmdb_overview = $tmdbData['overview'];
            $movie->save();

            return $this->jsonResponse(200, 'Data Updated Successfully', null, $movie);
        } catch (ClientException $e) {
            if ($e->hasResponse()) {
                $response = $e->getResponse();
                $statusCode = $response->getStatusCode();
                $responseBody = json_decode($response->getBody()->getContents(), true);
    
                \Log::error('TMDB API error: ', [
                    'status_code' => $statusCode,
                    'response_body' => $responseBody
                ]);
              
                if ($statusCode == 404) {
                    return $this->jsonResponse(404, 'Movie not found in TMDB', [$responseBody], null);
                }
                return $this->jsonResponse($statusCode, 'Error from TMDB API', [$responseBody], null);
            }
            return $this->jsonResponse(500, 'Failed to retrieve TMDB data', [$e->getMessage()], null);
            
        } catch (Exception $e) {
            \Log::error('Unexpected error: ' . $e->getMessage());
            return $this->jsonResponse(500, 'An unexpected error occurred', [$e->getMessage()], null);
        }

        
    }
}
