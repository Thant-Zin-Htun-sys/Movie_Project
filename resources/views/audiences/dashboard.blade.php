@extends('layout')

@section('content')
<div class="container mt-5">
    <h2>Your Movie Recommendations</h2>
    <p>We have curated these movies based on your preferences.</p>

    <div class="row">
        @forelse ($recommendedMovies as $movie)
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="https://via.placeholder.com/150" class="card-img-top" alt="{{ $movie->title }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $movie->title }}</h5>
                        <p class="card-text">{{ $movie->genre->name }}</p>
                        <a href="{{ route('audience.movies.view', $movie->id) }}" class="btn btn-primary">View Details</a>
                    </div>
                </div>
            </div>
        @empty
            <p>No recommendations available at the moment. Please rate more movies to get better recommendations.</p>
        @endforelse
    </div>
</div>
@endsection