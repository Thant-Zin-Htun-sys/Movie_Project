<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Rating;
use App\Models\Audience;
use App\Services\RecommendationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AudienceController extends Controller
{
    // Ensure the audience is authenticated
    public function __construct()
    {
        $this->middleware('auth:audience');
    }

    // Show the audience dashboard with recommendations
    public function dashboard(RecommendationService $recommendationService)
    {
        $audience = auth()->guard('audience')->user();
        $recommendedMovies = $recommendationService->recommendMovies($audience->id);

        return view('audience.dashboard', compact('recommendedMovies'));
    }

    // View a specific movie
    public function viewMovie(Movie $movie)
    {
        $averageRating = $movie->ratings()->avg('rating');
        return view('audience.movie', compact('movie', 'averageRating'));
    }

    // Store or update rating for a movie
    public function rateMovie(Request $request, $movieId)
    {
        $request->validate([
            'rating' => 'required|integer|between:1,5',
        ]);

        // Store or update the rating
        $rating = Rating::updateOrCreate(
            ['audience_id' => auth()->guard('audience')->id(), 'movie_id' => $movieId],
            ['rating' => $request->rating]
        );

        return back()->with('success', 'Your rating has been saved!');
    }

    // Show Audience Registration Form
    public function showRegisterForm()
    {
        return view('audience.auth.register');
    }

    // Audience Registration
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'email' => 'required|email|unique:audiences,email',
            'username' => 'required|string|max:255|unique:audiences,username',
            'password' => 'required|min:6|confirmed',
        ]);

        // Create new Audience
        $audience = Audience::create([
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
            'username' => $request->username,
            'password' => bcrypt($request->password),
        ]);

        // Log in the newly created audience
        Auth::guard('audience')->login($audience);

        return redirect()->route('audience.dashboard');
    }
}
