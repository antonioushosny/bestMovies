<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Movie;
use Illuminate\Foundation\Testing\WithFaker;

class MovieTest extends TestCase
{
    // use RefreshDatabase;
    use WithFaker;

    public function testIndex()
    {
        // Assuming you have some movies in the database
        // Movie::factory()->count(5)->create();

        $response = $this->withHeaders([
            'Secret-Key' => env('SECRET_KEY'),
        ])->get('/api/v001/movies');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'errors',
                'data' => [
                    'current_page',
                    'data' => [
                        '*' => [
                            'id',
                            'pos',
                            'year_2023',
                            'year_2022',
                            'title',
                            'director',
                            'year',
                            'country',
                            'length',
                            'genre',
                            'colour',
                            'is_favorite',
                            'tmdb_rating',
                            'tmdb_votes',
                            'tmdb_overview',
                            'created_at',
                            'updated_at',
                        ],
                    ],
                    'first_page_url',
                    'from',
                    'last_page',
                    'last_page_url',
                    'links' => [
                        '*' => [
                            'url',
                            'label',
                            'active',
                        ],
                    ],
                    'next_page_url',
                    'path',
                    'per_page',
                    'prev_page_url',
                    'to',
                    'total',
                ],
            ]);
    }

    public function testShow()
    {
        $movie = Movie::find(1);

        $response = $this->withHeaders([
            'Secret-Key' => env('SECRET_KEY'),
        ])->get("/api/v001/movies/{$movie->id}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'errors',
                'data' => [
                    'id',
                    'pos',
                    'year_2023',
                    'year_2022',
                    'title',
                    'director',
                    'year',
                    'country',
                    'length',
                    'genre',
                    'colour',
                    'is_favorite',
                    'created_at',
                    'updated_at',
                ]
            ]);
    }

    public function testStore()
    {
        $colours = ['BW', 'Col']; // Assuming $colours is an array of possible colours

        // Prepare the necessary data for the test
        $data = [
            'pos' => $this->faker->numberBetween(1, 10000),
            'year_2023' => (string)$this->faker->numberBetween(1, 50),
            'year_2022' => (string)$this->faker->numberBetween(1, 50),
            'title' => $this->faker->sentence,
            'director' => $this->faker->sentence,
            'year' => (string)$this->faker->numberBetween(1900, date('Y')),
            'country' => $this->faker->country,
            'length' => (string)$this->faker->numberBetween(1, 50),
            'genre' => $this->faker->word,
            'colour' => $this->faker->randomElement($colours),
            'is_favorite' => $this->faker->boolean,
            'tmdb_rating' => $this->faker->randomFloat(1, 0, 10),
            'tmdb_votes' => $this->faker->numberBetween(1, 10000),
            'tmdb_overview' => $this->faker->paragraph,
        ];
        $response = $this->withHeaders([
            'Secret-Key' => env('SECRET_KEY'),
        ])->postJson('/api/v001/movies', $data);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'errors',
                'data' => [
                    'id',
                    'pos',
                    'year_2023',
                    'year_2022',
                    'title',
                    'director',
                    'year',
                    'country',
                    'length',
                    'genre',
                    'colour',
                    'created_at',
                    'updated_at',
                ]
            ]);

        $this->assertDatabaseHas('movies', ['pos' => $data['pos']]);
    }

    public function testUpdate()
    {
        $movie = Movie::factory()->create();
        $colours = ['BW', 'Col'];
        $updatedData = [
            'pos' => $movie->pos,
            'year_2023' => (string)$this->faker->numberBetween(1, 50),
            'year_2022' => (string)$this->faker->numberBetween(1, 50),
            'title' => $this->faker->sentence,
            'director' => $this->faker->sentence,
            'year' => (string)$this->faker->numberBetween(1900, date('Y')),
            'country' => $this->faker->country,
            'length' => (string)$this->faker->numberBetween(1, 50),
            'genre' => $this->faker->word,
            'colour' => $this->faker->randomElement($colours),
            'is_favorite' => $this->faker->boolean,
            'tmdb_rating' => $this->faker->randomFloat(1, 0, 10),
            'tmdb_votes' => $this->faker->numberBetween(1, 10000),
            'tmdb_overview' => $this->faker->paragraph,
        ];

        $response = $this->withHeaders([
            'Secret-Key' => env('SECRET_KEY'),
        ])->putJson("/api/v001/movies/{$movie->id}", $updatedData);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'errors',
                'data' => [
                    'id',
                    'pos',
                    'year_2023',
                    'year_2022',
                    'title',
                    'director',
                    'year',
                    'country',
                    'length',
                    'genre',
                    'colour',
                    'is_favorite',
                    'created_at',
                    'updated_at',
                ]
            ]);
        $this->assertDatabaseHas('movies', ['pos' => $updatedData['pos'],'colour' => $updatedData['colour']]);

    }

    public function testDestroy()
    {
        $movie = Movie::factory()->create();

        $response = $this->withHeaders([
            'Secret-Key' => env('SECRET_KEY'),
        ])->delete("/api/v001/movies/{$movie->id}");

        $response->assertStatus(200)
            ->assertJson([
                'status' => 200,
                'message' => 'Data Destroyed Successfully',
                'data' => null,
            ]);

        $this->assertDatabaseMissing('movies', ['id' => $movie->id]);
    }

    public function testFavorite()
    {
        $movie = Movie::findOrFail(3);

        $response = $this->withHeaders([
            'Secret-Key' => 'b8e9f7c8a9d6f5b4c3a2e1d0b9e8f7c6a5b4c3a2e1d0f9e8d7c6b5a4c3d2e1f0',
        ])->postJson("/api/v001/movies/{$movie->id}/favorite");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'errors',
                'data' => [
                    'id',
                    'pos',
                    'year_2023',
                    'year_2022',
                    'title',
                    'director',
                    'year',
                    'country',
                    'length',
                    'genre',
                    'colour',
                    'is_favorite',
                    'created_at',
                    'updated_at',
                    'tmdb_rating',
                    'tmdb_votes',
                    'tmdb_overview'
                ]
            ]);

         // Verify the movie was updated in the database
         $this->assertDatabaseHas('movies', [
            'id' => $movie->id,
            'is_favorite' => true,
        ]);
    }


}
