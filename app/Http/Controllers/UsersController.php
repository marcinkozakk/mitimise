<?php

namespace App\Http\Controllers;


use App\User;
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

    function show(Request $request, $id)
    {
        return view('users.show', ['user' => User::findOrFail($id)]);
    }

    function search(Request $request)
    {
        return User::where('name', 'like', $request->s . '%')
            ->take(8)
            ->get();
    }
}