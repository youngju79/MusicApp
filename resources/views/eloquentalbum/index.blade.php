@extends('layouts.main')

@section('title', 'Albums (Eloquent)')

@section('content')
    @if (Auth::check())
        <div class="text-end mb-3">
            <a href="{{route('eloquentalbum.create')}}">New Album</a>
        </div>
    @endif
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Album</th>
                <th>Artist</th>
                <th>Creator</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($albums as $album)
                <tr>
                    <td>
                        {{$album->title}}
                    </td>
                    <td>
                        {{$album->artist->name}}
                    </td>
                    <td>
                        {{$album->user->name}}
                    </td>
                    <td>
                    @can ('view', $album)
                        <a href="{{route('eloquentalbum.edit', ['id' => $album->id])}}">Edit</a>
                    @endcan
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection