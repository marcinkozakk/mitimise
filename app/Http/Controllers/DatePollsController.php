<?php

namespace App\Http\Controllers;

use App\DatePoll;
use App\Meeting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class DatePollsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function setAvailability(Request $request, $meeting_id)
    {
        $meeting = Meeting::findOrFail($meeting_id);

        $this->authorize('setAvailability', $meeting);


        if(DatePoll
            ::where('meeting_id', $meeting_id)
            ->where('date', $request->date)->doesntExist()
        ) {
            $this->authorize('edit', $meeting);
            $request->validate([
                'date' => 'required|date|after:yesterday'
            ]);
        }

        $datePoll = DatePoll::firstOrNew([
            'user_id' => Auth::id(),
            'meeting_id' => $meeting_id,
            'date' => $request->date
        ]);

        $datePoll->availability = $request->availability;

        if($datePoll->save()) {
            Session::flash('alert-success', __('Choice has been saved'));
        } else {
            Session::flash('alert-danger', __('Unable to save your choice'));
        }

        return redirect(url()->previous() . '#date-poll')->withInput();
    }

    public function delete(Request $request)
    {
        $meeting = Meeting::findOrFail($request->meeting_id);

        $this->authorize('edit', $meeting);

        if(DatePoll::where('meeting_id', $request->meeting_id)
            ->where('date', $request->date)->delete()
        ) {
            Session::flash('alert-success', __('Day has been deleted'));
        } else {
            Session::flash('alert-danger', __('Unable to delete day'));
        }

        return redirect(url()->previous() . '#date-poll');
    }
}