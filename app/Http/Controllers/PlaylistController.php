<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlaylistController extends Controller
{
    public function index()
    {
        $playlists = DB::table('playlists')
            ->get();
        return view('playlist.index', [
            'playlists' => $playlists
        ]);
    }
    public function show($id)
    {
        $playlist = DB::table('playlists')
            ->where('id', '=', $id)
            ->first();
        $tracks = DB::table('playlist_track')
            ->join('tracks', 'track_id', '=', 'tracks.id')
            ->join('albums', 'album_id', '=', 'albums.id')
            ->join('artists', 'artist_id', '=', 'artists.id')
            ->join('genres', 'genre_id', '=', 'genres.id')
            ->where('playlist_id', '=', $id)
            ->get([
                'tracks.name AS track_name',
                'albums.title AS album_name',
                'artists.name AS artist_name',
                'genres.name AS genre_name'
            ]);
        return view('playlist.show', [
            'playlist' => $playlist,
            'tracks' => $tracks
        ]);
    }
    public function edit($id)
    {
        $playlist = DB::table('playlists')->where('id', '=', $id)->first();
        return view('playlist.edit', [
            'playlist' => $playlist
        ]);
    }
    public function update($id, $name, Request $request)
    {
        $request->validate([
            'name' => 'required|max:30|unique:playlists,name'
        ]);
        DB::table('playlists')->where('id', '=', $id)->update([
            'name' => $request->input('name')
        ]);
        return redirect()
            ->route('playlist.index')
            ->with('success', "$name was successfully renamed to {$request->input('name')}");
    }
}
