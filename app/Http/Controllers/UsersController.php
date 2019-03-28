<?php

namespace App\Http\Controllers;


use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class UsersController
 * @package App\Http\Controllers
 *
 * This controller is responsible for handling user actions requests
 */
class UsersController extends Controller
{

    /**
     * UsersController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show current user dashboard
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function me()
    {
        return view('users.me');
    }

    /**
     * Handle upload photo request
     *
     * @param Request $request
     * @return null|string
     */
    function uploadPhoto(Request $request)
    {
        $path = $request->photo->store('photos', 'public');

        return Auth::user()->setPhoto($path);
    }

    /**
     * Show specific user profile
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function show($id)
    {
        return view('users.show', ['user' => User::findOrFail($id)]);
    }

    /**
     * Search for user name
     *
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Collection
     */
    function search(Request $request)
    {
        return User::where('name', 'like', $request->s . '%')
            ->take(8)
            ->get();
    }
}