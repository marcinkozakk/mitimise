<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Meeting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CommentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Request $request, $meeting_id)
    {
        $this->authorize('comment', Meeting::findOrFail($meeting_id));

        $comment = new Comment();

        $comment->content = $request->comment_content;
        $comment->user_id = Auth::id();
        $comment->meeting_id = $meeting_id;

        if($comment->save()) {
            Session::flash('alert-success', __('Comment has been created'));
            return redirect(url()->previous() . '#comments');
        }

        Session::flash('alert-danger', __('Unable to create comment'));
        return redirect(url()->previous() . '#comments')->withInput();
    }

    public function delete(Request $request)
    {
        $comment = Comment::findOrFail($request->comment_id);

        $this->authorize('deleteComment', [Meeting::findOrFail($request->meeting_id), $comment]);

        if($comment->delete()) {
            Session::flash('alert-success', __('Comment has been deleted'));
        } else {
            Session::flash('alert-danger', __('Unable to delete comment'));
        }

        return redirect(url()->previous() . '#comments')->withInput();
    }
}