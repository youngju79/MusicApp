<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Album;
use App\Models\Artist;

class AlbumEloquentController extends Controller
{
    public function index()
    {
        $albums = Album::join('artists', 'artists.id', '=', 'albums.artist_id')
            ->with(['artist'])
            ->orderBy('artists.name')
            ->orderBy('title')  
            ->select('*', 'albums.id as id')
            ->get();
        return view('eloquentalbum.index', [
            'albums' => $albums
        ]);
    }
    public function create()
    {
        $artists = Artist::orderBy('name')->get();
        return view('eloquentalbum.create', [
            'artists' => $artists
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:50',
            'artist' => 'required|exists:artists,id',
        ]);

        $album = new Album();
        $album->title = $request->input('title');
        $album->artist_id = $request->input('artist');
        $album->save();
        return redirect()
            ->route('eloquentalbum.index')
            ->with('success', "Successfully created {$request->input('title')}");
    }
    public function edit($id)
    {
        $album = Album::find($id);
        $artists = Artist::orderBy('name')->get();
        return view('eloquentalbum.edit', [
            'album' => $album,
            'artists' => $artists
        ]);
    }
    public function update($id, Request $request)
    {
        $request->validate([
            'title' => 'required|max:50',
            'artist' => 'required|exists:artists,id',
        ]);

        $album = Album::find($id);
        $album->title = $request->input('title');
        $album->artist_id = $request->input('artist');
        $album->save();
        return redirect()
            ->route('eloquentalbum.edit', ['id' => $id])
            ->with('success', "Successfully updated {$request->input('title')}");
    }
}
