@extends('layouts.main')

@section('title', 'Tracks')

@section('content')
    <div class="text-end mb-3">
        <a href="{{route('track.create')}}">New Track</a>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Album Title</th>
                <th>Artist Name</th>
                <th>Media Type Name</th>
                <th>Genre Name</th>
                <th>Unit Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tracks as $track)
                <tr>
                    <td>
                        {{$track->track_name}}
                    </td>
                    <td>
                        {{$track->album_name}}
                    </td>
                    <td>
                        {{$track->artist_name}}
                    </td>
                    <td>
                        {{$track->mediatype_name}}
                    </td>
                    <td>
                        {{$track->genre_name}}
                    </td>
                    <td>
                        ${{$track->unit_price}}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection