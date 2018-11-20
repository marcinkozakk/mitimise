<?php

namespace App\Http\Controllers;

use App\Circle;
use App\Membership;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CirclesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Request $request)
    {
        $request->validate([
            'name_circle' => 'required|max:255'
        ]);

        $circle = new Circle;

        $circle->name = $request->name_circle;
        $circle->is_private = $request->is_private;
        $circle->user_id = \Auth::id();

        if($circle->save()) {
            $owner = new Membership;
            $owner->user_id = Auth::id();
            $owner->circle_id = $circle->id;
            if($owner->save()) {
                Session::flash('alert-success', __('Circle has been created'));
                return redirect()->route('circles.show', ['id' => $circle->id]);
            } else {
                $circle->delete();
            }
        }
        Session::flash('alert-danger', __('Unable to create circle'));


        return back()->withInput();
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:255'
        ]);

        $circle = Circle::findOrFail($id);

        $this->authorize('edit', $circle);

        $circle->name = $request->name;
        $circle->is_private = $request->is_private;

        if($circle->save()) {
            Session::flash('alert-success', __('Circle has been updated'));
            return redirect()->route('circles.show', ['id' => $circle->id]);
        }

        Session::flash('alert-danger', __('Unable to update circle'));
        return redirect()->route('circles.show', ['id' => $circle->id]);
    }

    public function show($id)
    {
        $circle = Circle::findOrFail($id);

        $this->authorize('show', $circle);

        return view('circles.show', ['circle' => $circle]);
    }

    public function delete($id)
    {
        $circle = Circle::findOrFail($id);

        $this->authorize('edit', $circle);

        $circle->members()->detach();
        $circle->delete();

        Session::flash('alert-success', __('Circle has been deleted'));
        return redirect()->route('home');
    }
}
