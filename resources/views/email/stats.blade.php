@extends('layouts.email')

@section('content')
    <div class="card mx-auto my-3" style="width: 25rem;">
        <img src="https://www.ctvnews.ca/polopoly_fs/1.4025970.1532451635!/httpImage/image.jpg_gen/derivatives/landscape_1020/image.jpg" class="card-img-top" alt="someone listening to music">
        <div class="card-body">
            <h5 class="card-title">Music-App Stats for This Year</h5>
            <p class="card-text">View the total number of artists, playlists, and tracks in music-app!</p>
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item">Total number of artists: {{$artist_total}}</li>
            <li class="list-group-item">Total number of playlists: {{$playlist_total}}</li>
            <li class="list-group-item">Total number of track minutes: {{$track_sum}}</li>
        </ul>
    </div>
@endsection