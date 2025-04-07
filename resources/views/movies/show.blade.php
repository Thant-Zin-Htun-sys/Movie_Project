@extends('layout')

@section('content')
    <div class="container mt-5">
        <div class="card shadow-lg border-0">
            <div class="card-body text-center">
                <h2 class="text-primary font-weight-bold">🎬 {{ $movie->title }}</h2>
                <p><strong>🎭 Genre:</strong> {{ $movie->genre }}</p>
                <p><strong>📅 Released Date:</strong> {{ $movie->released_date }}</p>
                <p><strong>⭐️ Rating:</strong> {{ number_format($averageRating, 1) ?? 'No ratings yet' }}</p>
            </div>
        </div>
@endsection
