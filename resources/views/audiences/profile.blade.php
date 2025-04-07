<!-- resources/views/profile/show.blade.php -->
@extends('layout')

@section('content')
    <div class="card">
        <div class="card-header">
            <h4>{{ $audience->name }}'s Profile</h4>
        </div>
        <div class="card-body">
            <h5>🎬 Genres You've Rated:</h5>
            <ul>
                @foreach($genres as $genre)
                    <li>{{ $genre }}</li>
                @endforeach
            </ul>

            <hr>

            <h5>⭐ Your Rated Movies:</h5>
            <table class="table">
                <thead>
                    <tr>
                        <th>Movie</th>
                        <th>Genre</th>
                        <th>Your Rating</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ratings as $rating)
                        <tr>
                            <td>{{ $rating->movie->title }}</td>
                            <td>{{ $rating->movie->genre }}</td>
                            <td>{{ $rating->rating }}/5</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
