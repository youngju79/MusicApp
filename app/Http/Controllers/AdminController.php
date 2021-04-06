<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Configuration;
use App\Models\User;
use App\Models\Artist;
use App\Models\Playlist;
use App\Models\Track;
use Illuminate\Support\Facades\Mail;
use App\Mail\Stats;
use Exception;

class AdminController extends Controller
{
    public function view()
    {
        return view('admin');
    }
    public function store(Request $request)
    {
        $request->validate([
            'toggle' => 'required|boolean'
        ]);
        $toggle = $request->input('toggle') ? true : false;
        $config = Configuration::where('name', '=', 'maintenance-mode')->first();
        $config->value = $toggle;
        $config->save();
        return redirect()
            ->route('admin.view')
            ->with('success', "Successfully changed maintenance mode");
    }
    public function email()
    {
        $users = User::all();
        $artist_total = Artist::all()->count();
        $playlist_total = Playlist::all()->count();
        $track_sum = (int)round(Track::all()->sum('milliseconds')/60000);
        foreach($users as $user){
            if($user->email){
                Mail::to($user->email)->queue(new Stats($artist_total, $playlist_total, $track_sum));
            }
            else{
                throw new Exception("User {$user->id} is missing an email");
            }
        }
        return redirect()
            ->route('admin.view')
            ->with('success', "Successfully emailed stats to users");
    }
}
