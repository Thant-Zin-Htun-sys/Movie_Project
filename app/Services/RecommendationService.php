<?php
namespace App\Services;

use App\Models\Rating;
use App\Models\Movie;

class RecommendationService
{
    /**
     * Get the user's genre preferences based on past ratings.
     *
     * @param int $audienceId
     * @return array
     */
    public function getUserPreferences($audienceId)
    {
        $ratings = Rating::with('movie.genre')
            ->where('audience_id', $audienceId)
            ->get();

        $preferences = [];

        foreach ($ratings as $rating) {
            // Group ratings by genre and sum them
            $genreId = $rating->movie->genre_id;
            $preferences[$genreId] = ($preferences[$genreId] ?? 0) + $rating->rating;
        }

        // Sort genres by most preferred
        arsort($preferences);
        return $preferences;
    }

    /**
     * Recommend movies based on user's genre preferences.
     *
     * @param int $audienceId
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function recommendMovies($audienceId, $limit = 10)
    {
        $preferences = $this->getUserPreferences($audienceId);

        // Get already rated movie IDs to exclude them from recommendations
        $ratedMovieIds = Rating::where('audience_id', $audienceId)->pluck('movie_id');

        // Get genre IDs from user preferences
        $preferredGenreIds = array_keys($preferences);

        // Recommend movies from the preferred genres that the user hasn't rated
        return Movie::whereNotIn('id', $ratedMovieIds)
            ->whereIn('genre_id', $preferredGenreIds)
            ->orderByRaw("FIELD(genre_id, " . implode(',', $preferredGenreIds) . ")")
            ->limit($limit)
            ->get();
    }
}
