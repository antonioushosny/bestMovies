<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MovieFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $colours = ["BW", "COL" ];
        return [
            'pos'=>$this->faker->numberBetween(1, 10000),  
            'year_2023'=>$this->faker->numberBetween(1, 50),
            'year_2022'=>$this->faker->numberBetween(1, 50),
            'title'=>$this->faker->sentence,
            'director'=>$this->faker->sentence,
            'year'=>$this->faker->numberBetween(1900, date('Y')),
            'country'=>$this->faker->country,
            'length'=>$this->faker->numberBetween(1, 50),
            'genre'=> $this->faker->word,
            'colour'=>$this->faker->randomElement($colours),
            'is_favorite'=> $this->faker->boolean,
            'tmdb_rating'=> $this->faker->randomFloat(1, 0, 10),
            'tmdb_votes'=>$this->faker->numberBetween(1, 10000),
            'tmdb_overview'=>$this->faker->paragraph,
        ];
    }
}
