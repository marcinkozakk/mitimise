@php
    $class = $groupedGuests['going']->contains('id', Auth::id()) ? 'going' : 'undecided';
@endphp

<div id="comments" class="comments mt-3">
    <div class="row">
        <h2>
            {{ __('Comments') }}
        </h2>
    </div>
    @can('comment', $meeting)
        <form action="{{ route('comments.create', ['meeting_id' => $meeting->id]) }}" method="post" class="row {{ $class }}">
            @csrf
            <div class="col-1">
                <img class="avatar-border" src="{{ Auth::user()->photo }}">
            </div>
            <div class="col-5">
                    <textarea name="comment_content" rows="3" class="form-control" placeholder="{{ __('write comment...') }}"></textarea>
                    <button class="btn btn-{{ $class }} mt-1" type="submit">
                        {{ __('Submit') }}
                    </button>
            </div>
        </form>
    @endcan
    @foreach($meeting->comments as $comment)
        <div class="row mt-2 {{ $groupedGuests['going']->contains('id',$comment->user->id ) ? 'going' : 'undecided'}}">
            <div class="col-1">
                <img data-toggle="tooltip" title="{{ $comment->user->name }}" class="avatar-border" src="{{ $comment->user->photo }}">
            </div>
            <div class="col-5 align-self-center">
                <div class="comment-content rounded p-2 border-dark">
                    {!! nl2br(e($comment->content)) !!}
                </div>
                <span class="text-muted">
                    <small>
                        <abbr title="{{ $comment->created_at }}">
                            {{\Jenssegers\Date\Date::parse($comment->created_at)->diffForHumans( Date::now(), true) . ' ' . __('ago') }}
                        </abbr>
                    </small>
                </span>
                @can('deleteComment', [$meeting, $comment])
                    <a class="ml-1" data-toggle="modal" data-target="#delete-comment" data-comment-id="{{ $comment->id }}">
                        <small>
                            <i data-toggle="tooltip" title="{{ __('Delete') }}" class="fas fa-trash fa-sm text-muted"></i>
                        </small>
                    </a>
                @endcan
            </div>
        </div>
    @endforeach
</div>