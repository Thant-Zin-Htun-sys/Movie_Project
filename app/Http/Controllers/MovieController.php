<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Genre;
use App\Models\Rating;
use Illuminate\Http\Request;
use App\Services\RecommendationService;  // Import the RecommendationService

class MovieController extends Controller
{
    public function index()
    {
        $movies = Movie::orderByDesc('id')->get();

        return view('movies.index', compact('movies'));
    }

    public function show(Movie $movie)
    {
        // Get the average rating of the movie
        $averageRating = $movie->ratings()->avg('rating');

        return view('movies.show', compact('movie', 'averageRating'));
    }

    public function create()
    {
        // Pass genres to the view for creating a movie
        $genres = Genre::all();
        return view('movies.create', compact('genres'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'genre_id' => 'required|exists:genres,id',  // Ensure that genre_id is valid
            'released_date' => 'required|date',
        ]);

        // Create the movie with the selected genre
        Movie::create([
            'title' => $request->title,
            'genre_id' => $request->genre_id,
            'released_date' => $request->released_date,
        ]);

        return redirect()->route('movies.index')->with('success', 'Movie added successfully!');
    }

    public function edit($id)
    {
        $movie = Movie::findOrFail($id);
        $genres = Genre::all();  // Pass genres to the view for editing

        return view('movies.edit', compact('movie', 'genres'));
    }

    public function update(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'title' => 'required|string|max:255',
            'genre_id' => 'required|exists:genres,id',  // Ensure genre_id is valid
            'released_date' => 'required|date',
        ]);

        // Find the movie
        $movie = Movie::findOrFail($id);

        // Update movie attributes
        $movie->update([
            'title' => $request->title,
            'genre_id' => $request->genre_id,
            'released_date' => $request->released_date,
        ]);

        return redirect()->route('movies.index')->with('success', 'Movie updated successfully!');
    }

    public function destroy($id)
    {
        $movie = Movie::findOrFail($id);
        $movie->delete();

        return redirect()->route('movies.index')->with('success', 'Movie deleted successfully!');
    }

    /**
     * Show movie recommendations for the logged-in audience.
     *
     * @param RecommendationService $recommendationService
     * @return \Illuminate\View\View
     */
    public function recommendations(RecommendationService $recommendationService)
    {
        $audience = auth()->guard('audience')->user();  // Get the logged-in audience

        // Get recommended movies based on the audience's ratings
        $recommendedMovies = $recommendationService->recommendMovies($audience->id);

        // Return to a view with recommendations
        return view('movies.recommendations', compact('recommendedMovies'));
    }
}

