<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TrackController extends Controller
{
    public function index()
    {
        $tracks = DB::table('tracks')
            ->join('albums', 'album_id', '=', 'albums.id')
            ->join('artists', 'artist_id', '=', 'artists.id')
            ->join('media_types', 'media_type_id', '=', 'media_types.id')
            ->join('genres', 'genre_id', '=', 'genres.id')
            ->get([
                'tracks.name AS track_name',
                'albums.title AS album_name',
                'artists.name AS artist_name',
                'media_types.name AS mediatype_name',
                'genres.name AS genre_name',
                'unit_price'
            ]);
        return view('track.index', [
            'tracks' => $tracks
        ]);
    }
    public function create()
    {
        $albums = DB::table('albums')->orderBy('title')->get();
        $media_types = DB::table('media_types')->orderBy('name')->get();
        $genres = DB::table('genres')->orderBy('name')->get();
        return view('track.create', [
            'albums' => $albums,
            'media_types' => $media_types,
            'genres' => $genres
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'album' => 'required|exists:albums,id',
            'media_type' => 'required|exists:media_types,id',
            'genre' => 'required|exists:genres,id',
            'unit_price' => 'required|numeric'
        ]);
        DB::table('tracks')->insert([
            'name' => $request->input('name'),
            'album_id' => $request->input('album'),
            'media_type_id' => $request->input('media_type'),
            'genre_id' => $request->input('genre'),
            'unit_price' => $request->input('unit_price')
        ]);
        return redirect()
            ->route('track.index')
            ->with('success', "The track {$request->input('name')} was successfully created");
    }
}
