@extends('layout')

@section('content')
<div class="card mt-5">
    <h2 class="card-header">Edit Movie</h2>
    <br>
    <div class="card-body">
        <form action="{{ route('admin.movies.update', $movie->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="inputTitle" class="form-label"><strong>Title: </strong></label>
                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" id="inputTitle" value="{{ $movie->title }}">
                @error('title')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="inputGenre" class="form-label"><strong>Genre: </strong></label>
                <select name="genre_id" class="form-control @error('genre_id') is-invalid @enderror">
                    @foreach($genres as $genre)
                        <option value="{{ $genre->id }}" {{ $movie->genre_id == $genre->id ? 'selected' : '' }}>{{ $genre->name }}</option>
                    @endforeach
                </select>
                @error('genre_id')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="inputReleasedDate" class="form-label"><strong>Released Date: </strong></label>
                <input type="date" name="released_date" class="form-control @error('released_date') is-invalid @enderror" value="{{ $movie->released_date }}">
                @error('released_date')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-success"><i class="fa-solid fa-floppydisk"></i> Save Changes</button>
            <a class="btn btn-primary" href="{{ route('movies.index') }}"><i class="fa fa-arrow-left"></i> Back</a>
        </form>
    </div>
</div>
@endsection