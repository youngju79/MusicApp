<?php

use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PlaylistController;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\AlbumEloquentController;
use App\Http\Controllers\TrackController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use App\Models\Artist;
use App\Models\Track;
use App\Models\Genre;
use App\Models\Album;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

if (env('APP_ENV') !== 'local') {
    URL::forceScheme('https');
}

Route::get('/', function () {
    return redirect()->route('album.index');
});

Route::get('/eloquent', function(){
    // QUERYING
    // return view('eloquent.artists', [
    //     'artists' => Artist::orderBy('name', 'desc')->get()
    // ]);
    // return view('eloquent.tracks', [
    //     'tracks' => Track::all()
    // ]);
    // return view('eloquent.tracks', [
    //     'tracks' => Track::where('unit_price', '>', 0.99)->orderBy('name')->get()
    // ]);
    // return view('eloquent.artist', [
    //     'artist' => Artist::find(3)
    // ]);
    
    // CREATING
    // $genre = new Genre();
    // $genre->name = 'Hip Hop';
    // $genre->save();

    // DELETING
    // $genre = Genre::find(26);
    // $genre->delete();

    // UPDATING
    // $genre = Genre::where('name', '=', 'Alternative and Punk')->first();
    // $genre->name = "Alternative & Punk";
    // $genre->save();

    // RELATIONSHIPS    
    // return view('eloquent.has-many', [
    //     'artist' => Artist::find(50)
    // ]);
    // return view('eloquent.belongs-to', [
    //     'album' => Album::find(152)
    // ]);
 
    // Has N+1 problem
    // return view('eloquent.eager-loading', [
    //     'tracks' => Track::where('unit_price', '>', 0.99)
    //         ->orderBy('name')
    //         ->limit(5)
    //         ->get()
    // ]);
    // EAGER LOADING (fixes N+1 problem)
    return view('eloquent.eager-loading', [
        'tracks' => Track::with('album')
            ->where('unit_price', '>', 0.99)
            ->orderBy('name')
            ->limit(5)
            ->get()
    ]);
});

// MVC- Model View Controller

Route::middleware(['not-maintenance'])->group(function(){
    Route::get('/playlists', [PlaylistController::class, 'index'])->name('playlist.index');
    Route::get('/playlists/{id}', [PlaylistController::class, 'show'])->name('playlist.show');
    Route::get('/playlists/{id}/edit', [PlaylistController::class, 'edit'])->name('playlist.edit');
    Route::post('/playlists/{id}/{name}', [PlaylistController::class, 'update'])->name('playlist.update');

    Route::get('/albums', [AlbumController::class, 'index'])->name('album.index');
    Route::get('/albums/create', [AlbumController::class, 'create'])->name('album.create');
    Route::post('/albums', [AlbumController::class, 'store'])->name('album.store');
    Route::get('/albums/{id}/edit', [AlbumController::class, 'edit'])->name('album.edit');
    Route::post('/albums/{id}', [AlbumController::class, 'update'])->name('album.update');

    Route::get('/eloquentalbums', [AlbumEloquentController::class, 'index'])->name('eloquentalbum.index');

    Route::get('/tracks', [TrackController::class, 'index'])->name('track.index');
    Route::get('/tracks/new', [TrackController::class, 'create'])->name('track.create');
    Route::post('/tracks', [TrackController::class, 'store'])->name('track.store');

    Route::get('/register', [RegistrationController::class, 'index'])->name('registration.index');
    Route::post('/register', [RegistrationController::class, 'register'])->name('registration.create');

    Route::middleware(['custom-auth'])->group(function(){
        Route::get('/eloquentalbums/create', [AlbumEloquentController::class, 'create'])->name('eloquentalbum.create');
        Route::post('/eloquentalbums', [AlbumEloquentController::class, 'store'])->name('eloquentalbum.store');
        Route::get('/eloquentalbums/{id}/edit', [AlbumEloquentController::class, 'edit'])->name('eloquentalbum.edit');
        Route::post('/eloquentalbums/{id}', [AlbumEloquentController::class, 'update'])->name('eloquentalbum.update');
    });
});
Route::view('/maintenance', 'maintenance')->name('maintenance');

Route::get('/login', [AuthController::class, 'loginForm'])->name('auth.loginForm');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');

Route::middleware(['custom-auth'])->group(function(){
    Route::middleware(['not-blocked'])->group(function(){
        Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
        Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoice.index');
        Route::get('/invoices/{id}', [InvoiceController::class, 'show'])->name('invoice.show');
    });
    Route::middleware(['admin'])->group(function(){
        Route::get('/admin', [AdminController::class, 'view'])->name('admin.view');
        Route::post('/admin', [AdminController::class, 'store'])->name('admin.store');
    });
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
    Route::view('/blocked', 'blocked')->name('blocked');
});