<?php

namespace App\Http\Controllers;

use App\Invitation;
use App\Meeting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

/**
 * This controller is responsible for handling invitations actions requests
 *
 * Class InvitationsController
 * @package App\Http\Controllers
 */
class InvitationsController extends Controller
{
    /**
     * InvitationsController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Create new invitations from given array
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Throwable
     */
    public function invite(Request $request)
    {
        $this->authorize('edit', Meeting::findOrFail($request->meeting_id));

        Invitation::createInvitations($request->users_id, $request->meeting_id);

        Session::flash('alert-success', __('Invitations has been sent'));
        return redirect()->back();
    }

    /**
     * Delete invitation for specific user and meeting by id
     *
     * @param $user_id
     * @param $meeting_id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function delete($user_id, $meeting_id)
    {
        $this->authorize('edit', Meeting::findOrFail($meeting_id));

        if(
            !Invitation::where('user_id', $user_id)
                ->where('meeting_id', $meeting_id)
                ->delete()
        ) {
            Session::flash('alert-danger', __('Unable to remove invitation'));
        }
        return redirect()->back();
    }

    /**
     * Set state for invitation of current user and specific meeting
     *
     * @param $meeting_id
     * @param $state "going" || "undecided" || "cant"
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function setState($meeting_id, $state) {
        $this->authorize('setState', Meeting::findOrFail($meeting_id));

        $invitation = Invitation::where('meeting_id', $meeting_id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if($state == 'going') {

            $invitation->state = 'going';

            if($invitation->save()) {
                Session::flash('alert-success', __('Your answer has been saved'));
                return redirect()->back();
            }
        } else if($state == 'undecided') {

            $invitation->state = 'undecided';

            if($invitation->save()) {
                Session::flash('alert-success', __('Your answer has been saved'));
                return redirect()->back();
            }

        } else if($state == 'cant') {

            if($invitation->delete()) {
                Session::flash('alert-success', __('Your answer has been saved'));
                return redirect(route('home'));
            }
        }

        Session::flash('alert-danger', __('Something went wrong'));
        return redirect()->back();
    }

}