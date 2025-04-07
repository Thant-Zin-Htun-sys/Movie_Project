<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\AudienceController;
use App\Http\Controllers\AdminController;

// Public Routes
Route::get('/', function () {
    return view('welcome');
});

// Audience Routes
Route::prefix('audience')->name('audience.')->group(function () {

    // Show Audience Registration Form
    Route::get('register', [AudienceController::class, 'showRegisterForm'])->name('registerForm');

    // Handle Audience Registration
    Route::post('register', [AudienceController::class, 'register'])->name('register');

    // Show Audience Login Form
    Route::get('login', [AudienceController::class, 'showLoginForm'])->name('loginForm');

    // Handle Audience Login
    Route::post('login', [AudienceController::class, 'login'])->name('login');

    // Audience Dashboard (Only Authenticated Audience)
    Route::middleware('auth:audience')->get('dashboard', [AudienceController::class, 'dashboard'])->name('dashboard');

    // View Movie and Rating Movie (Only Authenticated Audience)
    Route::middleware('auth:audience')->get('movies/{movie}', [AudienceController::class, 'viewMovie'])->name('movies.view');
    Route::middleware('auth:audience')->post('movies/{movieId}/rate', [AudienceController::class, 'rateMovie'])->name('movies.rate');
});

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {

    // Admin Login
    Route::get('login', [AdminController::class, 'showLoginForm'])->name('loginForm');
    Route::post('login', [AdminController::class, 'login'])->name('login');

    // Admin Dashboard (Only Authenticated Admin)
    Route::middleware('auth:admin')->get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Admin Movies CRUD (Only Authenticated Admin)
    Route::middleware('auth:admin')->resource('movies', AdminController::class)->except(['show']);

    // Admin Manage Genres (Only Authenticated Admin)
    Route::middleware('auth:admin')->get('genres', [AdminController::class, 'manageGenres'])->name('genres.index');
    Route::middleware('auth:admin')->post('genres', [AdminController::class, 'createGenre'])->name('genres.create');
});

// Movie Routes (For Audience to rate movies)
Route::prefix('movies')->group(function () {

    // Rate a Movie (Authenticated Audience)
    Route::post('{movieId}/rate', [RatingController::class, 'store'])->name('ratings.store')->middleware('auth:audience');

    // Show All Ratings for a Movie
    Route::get('{movieId}/ratings', [RatingController::class, 'showRatings'])->name('ratings.show');
});

// Movie Routes for Admin (CRUD Operations)
Route::prefix('admin/movies')->middleware('auth:admin')->group(function () {
    Route::get('/', [MovieController::class, 'index'])->name('movies.index');
    Route::get('create', [MovieController::class, 'create'])->name('movies.create');
    Route::post('store', [MovieController::class, 'store'])->name('movies.store');
    Route::get('edit/{id}', [MovieController::class, 'edit'])->name('movies.edit');
    Route::put('update/{id}', [MovieController::class, 'update'])->name('movies.update');
    Route::delete('destroy/{id}', [MovieController::class, 'destroy'])->name('movies.destroy');
    Route::get('recommendations', [MovieController::class, 'recommendations'])->name('movies.recommendations');
});
