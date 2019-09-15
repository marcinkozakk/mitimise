<?php


namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class PlacesController extends Controller
{
    /**
     * PlacesController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function show()
    {
        return view('places.show', [
            'pastPlaces' => Auth::user()->pastMeetings->pluck('place')->unique('id'),
            'incomingPlaces' => Auth::user()->incomingMeetings->pluck('place')->unique('id')
        ]);
    }
}