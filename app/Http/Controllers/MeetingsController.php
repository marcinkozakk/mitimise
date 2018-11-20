<?php

namespace App\Http\Controllers;

use App\Circle;
use App\Invitation;
use App\Meeting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class MeetingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Request $request)
    {
        $request->validate([
            'name_meeting' => 'required|max:255',
            'starts_at' => 'nullable|date',
            'ends_at' => 'nullable|date|after:starts_at',
        ]);

        $meeting = new Meeting;

        $meeting->name = $request->name_meeting;
        $meeting->description = $request->description ? $request->description : '';
        $meeting->is_private = $request->is_private;
        $meeting->organizer_id = Auth::id();
        $meeting->is_canceled = 0;

        if(!$request->null_date) {
            $meeting->starts_at = $request->starts_at;
            $meeting->ends_at = $request->ends_at;
        }

        if($meeting->save()) {
            $organizer = new Invitation;
            $organizer->user_id = Auth::id();
            $organizer->meeting_id = $meeting->id;
            $organizer->state = 'going';


            if($organizer->save()) {
                if($request->circle_id) {
                    $circle = Circle::find($request->circle_id);

                    Invitation::createInvitations($circle->members->pluck('id'), $meeting->id);
                }

                Session::flash('alert-success', __('Meeting has been created'));
                return redirect()->route('meetings.show', ['id' => $meeting->id]);
            } else {
                $meeting->delete();
            }
        }
        Session::flash('alert-danger', __('Unable to create meeting'));
        return back()->withInput();
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:255',
            'starts_at' => 'nullable|date',
            'ends_at' => 'nullable|date|after:starts_at',
        ]);

        $meeting = Meeting::findOrFail($id);

        $this->authorize('edit', $meeting);

        $meeting->name = $request->name;
        $meeting->description = $request->description ? $request->description : '';
        $meeting->is_private = $request->is_private;

        if(!$request->null_date) {
            $meeting->starts_at = $request->starts_at;
            $meeting->ends_at = $request->ends_at;
        }

        if($meeting->save()) {
            Session::flash('alert-success', __('Meeting has been updated'));
            return redirect()->route('meetings.show', ['id' => $meeting->id]);
        }

        Session::flash('alert-danger', __('Unable to update meeting'));
        return redirect()->route('meetings.show', ['id' => $meeting->id]);
    }

    public function show($id)
    {
        $meeting = Meeting::findOrFail($id);

        $this->authorize('show', $meeting);

        return view('meetings.show', ['meeting' => $meeting]);
    }

    public function cancel($id)
    {
        $meeting = Meeting::find($id);

        $this->authorize('edit', $meeting);

        $meeting->is_canceled = 1;

        $meeting->saveOrFail();

        return redirect()->back();
    }

}