<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    /**
     * Store a rating for a movie by the logged-in audience.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, $movieId)
    {
        $request->validate([
            'rating' => 'required|integer|between:1,5',  // Rating must be between 1 and 5
        ]);

        $movie = Movie::findOrFail($movieId);

        $audience = Auth::guard('audience')->user();

        $existingRating = Rating::where('audience_id', $audience->id)
            ->where('movie_id', $movie->id)
            ->first();

        if ($existingRating) {
            $existingRating->update([
                'rating' => $request->rating,
            ]);
        } else {
            Rating::create([
                'audience_id' => $audience->id,
                'movie_id' => $movie->id,
                'rating' => $request->rating,
            ]);
        }

        return redirect()->route('movies.show', $movieId)->with('success', 'Rating added successfully!');
    }

    /**
     * Show the ratings of a movie.
     *
     * @param int $movieId
     * @return \Illuminate\View\View
     */
    public function showRatings($movieId)
    {
        $movie = Movie::findOrFail($movieId);
        $ratings = $movie->ratings()->with('audience')->get();  // Load all ratings for the movie

        return view('movies.ratings', compact('movie', 'ratings'));
    }
}
