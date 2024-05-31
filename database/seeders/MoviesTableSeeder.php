<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Movie;
use League\Csv\Reader;

class MoviesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $csv = Reader::createFromPath(base_path('database/data/movies.csv'), 'r');
        $csv->setHeaderOffset(0);

        foreach ($csv as $record) {
            Movie::create([
                'pos' => $record['Pos'],
                'year_2023' => $record['2023'],
                'year_2022' => $record['2022'],
                'title' => $record['Title'],
                'director' => $record['Director'],
                'year' => $record['Year'],
                'country' => $record['Country'],
                'length' => $record['Length'],
                'genre' => $record['Genre'],
                'colour' => $record['Colour'],
            ]);
        }
    }
}
