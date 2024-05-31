<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'pos', 'year_2023', 'year_2022', 'title', 'director', 'year', 'country', 'length', 'genre', 'colour','is_favorite','tmdb_rating','tmdb_votes','tmdb_overview',
    ];

    public function scopeGenre($query, $genre)
    {
        if ($genre) {
            return $query->where('genre', 'like', '%' . $genre . '%');
        }
        return $query;
    }

    public function scopeSearch($query, $searchTerm)
    {
        if ($searchTerm) {
            return $query->where('title', 'like', '%' . $searchTerm . '%')
                         ->orWhere('director', 'like', '%' . $searchTerm . '%');
        }
        return $query;
    }
}
