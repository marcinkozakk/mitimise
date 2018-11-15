<?php

namespace App\Http\Controllers;

use App\Circle;
use App\Membership;
use Illuminate\Http\Request;

class MembershipsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'circle_id' => 'required'
        ]);

        $membership = Membership::firstOrCreate([
            'user_id' => $request->user_id,
            'circle_id' => $request->circle_id
        ]);


        return $membership;
    }

    public function delete(Request $request)
    {
        $this->authorize('edit', Circle::findOrFail($request->circle_id));

        return Membership::where('user_id', '=', $request->user_id)
            ->where('circle_id', '=', $request->circle_id)->delete();
    }
}