<div class="card-header">{{ __('Meetings you are organizing') }}</div>
<div class="list-group list-group-flush">
    @php
    $meetings = $user->meetings;
    @endphp
    @if($meetings->count() == 0)
        <p class="list-group-item">{{ __('You don\'t organize any meeting, create it now:') }}</p>
    @else
        @foreach($meetings as $meeting)
            <div class="list-group-item">
                <div class="row">
                    <div class="col-sm-4">
                        <h4 class="d-flex align-items-center mb-0 mt-1">
                            <a href="{{ route('meetings.show', ['id' => $meeting->id]) }}">
                                {{ $meeting->name }}
                            </a>
                        </h4>
                    </div>
                    <div class="col-sm-8">
                        {{ __('Starts at') }}:
                        @if(!$meeting->starts_at)
                            {{ __('Unset') }}
                        @elseif(Date::parse($meeting->starts_at)->isPast())
                            {{ __('Meeting has already started') }}
                        @else
                            {{ __('in') }}
                            {{\Jenssegers\Date\Date::parse($meeting->starts_at)->diffForHumans( Date::now(), true) }}
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    @endif
    <button type="button" class="btn btn-primary m-4" data-toggle="modal" data-target="#add-meeting">
        {{ __('Create meeting') }}
    </button>
</div>
@include('meetings.add-modal')