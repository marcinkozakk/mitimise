<?php

namespace App\Http\Controllers;

use App\Circle;
use App\Membership;
use Illuminate\Http\Request;

/**
 * This controller is responsible for handling memberships actions requests
 *
 * Class MembershipsController
 * @package App\Http\Controllers
 */
class MembershipsController extends Controller
{
    /**
     * MembershipsController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Create new member and return it OR if membership exist just return it
     *
     * @param Request $request
     * @return mixed
     */
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

    /**
     * Delete specific member
     *
     * @param Request $request
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function delete(Request $request)
    {
        $this->authorize('edit', Circle::findOrFail($request->circle_id));

        return Membership::where('user_id', '=', $request->user_id)
            ->where('circle_id', '=', $request->circle_id)->delete();
    }
}