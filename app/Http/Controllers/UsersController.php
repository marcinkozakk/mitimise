<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    function me()
    {
        return view('users.me');
    }

    function uploadPhoto(Request $request)
    {
        $path = $request->photo->store('photos', 'public');

        return Auth::user()->setPhoto($path);
    }
}