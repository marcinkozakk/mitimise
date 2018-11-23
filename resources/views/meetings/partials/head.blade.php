<div class="jumbotron py-3">
    <h1 class="display-2">
        {{ $meeting->name }}
    </h1>
    <button class="btn btn-sm btn-primary">
        @if($meeting->is_private)
            <i data-toggle="tooltip" title="{{ __('Only you can view guests') }}"  class="fas fa-lock"></i>
        @else
            <i data-toggle="tooltip" title="{{ __('All can view everyone') }}" class="fas fa-users"></i>
        @endif
    </button>
    @can('edit', $meeting)
        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#invite-modal">{{ __('Invite') }}</button>
        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#edit-meeting">{{ __('Edit') }}</button>
        <button type="button" class="btn btn-sm btn-outline-danger" data-toggle="modal" data-target="#cancel-meeting">{{ __('Cancel meeting') }}</button>
    @endcan
    @can('revertCancelation', $meeting)
        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#revert-meeting">{{ __('Revert meeting') }}</button>
    @endcan
    <p class="lead">{!! nl2br(e($meeting->description)) !!}</p>
    <hr class="my-4">
    <div class="row">
        <dl class="col-6">
            <dt><strong>{{ __('Organizer') }}</strong></dt>
            <dd>
                <a href="{{ route('users.show', ['id' => $meeting->organizer_id]) }}">{{ $meeting->organizer->name }}</a>
            </dd>
            <dt><strong>{{ __('Starts at') }}</strong></dt>
            <dd>
                @if($meeting->starts_at)
                    {{ Date::parse($meeting->starts_at)->format('l H:i, j F Y') }}
                @else
                    {{ __('Unset') }}
                @endif
            </dd>
            <dt><strong>{{ __('Ends at') }}</strong></dt>
            <dd>
                @if($meeting->ends_at)
                    {{ Date::parse($meeting->ends_at)->format('l H:i, j F Y') }}
                @else
                    {{ __('Unset') }}
                @endif
            </dd>
        </dl>
    </div>
</div>
