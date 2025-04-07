@extends('layout')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-3">
            <div class="card text-white bg-primary mb-4">
                <div class="card-header">Movies</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $movieCount }}</h5>
                    <p class="card-text">Total Movies</p>
                    <a href="{{ route('movies.index') }}" class="btn btn-light">Manage Movies</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success mb-4">
                <div class="card-header">Genres</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $genreCount }}</h5>
                    <p class="card-text">Total Genres</p>
                    <a href="{{ route('genres.index') }}" class="btn btn-light">Manage Genres</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning mb-4">
                <div class="card-header">Audiences</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $audienceCount }}</h5>
                    <p class="card-text">Total Audiences</p>
                    <a href="{{ route('audiences.index') }}" class="btn btn-light">Manage Audiences</a>
                </div>
            </div>
        </div>
        
    </div>
</div>
@endsection