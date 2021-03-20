<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Configuration;

class AdminController extends Controller
{
    public function view(){
        return view('admin');
    }
    public function store(Request $request){
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
}
