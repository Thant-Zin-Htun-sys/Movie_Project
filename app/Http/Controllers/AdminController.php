<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Genre;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Ensure the admin is authenticated
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    // Admin Dashboard
    public function dashboard()
    {
        return view('dashboard');
    }

    // Show all movies
    public function moviesIndex()
    {
        $movies = Movie::all();
        return view('movies.index', compact('movies'));
    }

    // Show the movie creation form
    public function createMovie()
    {
        $genres = Genre::all();
        return view('movies.create', compact('genres'));
    }

    // Store a new movie
    public function storeMovie(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'genre_id' => 'required|exists:genres,id',
            'released_date' => 'required|date',
        ]);

        Movie::create([
            'title' => $request->title,
            'genre_id' => $request->genre_id,
            'released_date' => $request->released_date,
        ]);

        return redirect()->route('admin.movies.index')->with('success', 'Movie added successfully!');
    }

    // Show the genre management page
    public function manageGenres()
    {
        $genres = Genre::all();
        return view('genres.index', compact('genres'));
    }

    // Create a new genre
    public function createGenre(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:genres',
        ]);

        Genre::create(['name' => $request->name]);

        return redirect()->route('genres.index')->with('success', 'Genre added successfully!');
    }
}
