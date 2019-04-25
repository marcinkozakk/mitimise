@if($meeting->starts_at == null && ($meeting->date_polls->count() > 0 || Auth::user()->can('edit', $meeting)))
    <div class="card mt-3 date-poll" id="date-poll">
        <div class="card-header">
            @if($meeting->date_polls->count() > 0)
                <div class="row align-items-center">
                    @can('edit', $meeting)
                        <div class="col-1">
                            {{ __('Edit') }}
                        </div>
                    @endcan
                    <div class="col-2">
                        <h5 class="m-0">{{ __('Date poll') }}</h5>
                    </div>
                    <div class="col-2 text-center">
                        {{ __('Availability') }}
                    </div>
                    <div class="col">
                        <span class="text-success">{{ __('Available') }}</span>
                        <span>/</span>
                        <span class="text-danger">{{ __('Unavailable') }}</span>
                    </div>
                </div>
            @else
                {{ __('Create date poll and get to know when your guests are available') }}
            @endif
        </div>
        <ul class="list-group list-group-flush">
            @php
                $formRoute = route('datePolls.setAvailability', ['meeting_id' => $meeting->id]);
            @endphp
            @foreach($meeting->date_polls as $date)
                <li class="list-group-item">
                    <div class="row">
                        @can('edit', $meeting)
                            <div class="col-1 align-self-center">
                                <a data-date="{{ $date->date }}" data-toggle="modal" data-target="#setDate-meeting" class="text-primary">
                                    <i data-toggle="tooltip" title="{{ __('Set as starting day') }}" class="fas fa-2x fa-calendar-check"></i>
                                </a>
                                <a data-date="{{ $date->date }}" data-toggle="modal" data-target="#delete-day" class="text-dark">
                                    <i data-toggle="tooltip" title="{{ __('Delete this day from poll') }}" class="fas fa-trash"></i>
                                </a>
                            </div>
                        @endcan
                        <div class="col-2 pt-2 align-self-center">
                            <h5>{{ Date::parse($date->date)->format('D, j F') }}</h5>
                        </div>
                        <div class="col-2 text-center">
                            @php
                                $you = $date->polls->firstWhere('user_id', Auth::id());
                            @endphp
                            @if($you && $you->availability == 'yes')
                                <form method="post" action="{{ $formRoute }}" class="d-inline-block">
                                    @csrf
                                    <input type="hidden" name="date" value="{{ Date::parse($date->date)->toDateString() }}">
                                    <input type="hidden" name="availability">
                                    <button type="submit" class="btn p-0 text-success current">
                                        <i class="fas fa-3x fa-check-circle"></i>
                                    </button>
                                </form>
                            @elseif($you && $you->availability == 'no')
                                <form method="post" action="{{ $formRoute }}" class="d-inline-block">
                                    @csrf
                                    <input type="hidden" name="date" value="{{ Date::parse($date->date)->toDateString() }}">
                                    <input type="hidden" name="availability">
                                    <button type="submit" class="btn p-0 text-danger current">
                                        <i class="fas fa-3x fa-times-circle"></i>
                                    </button>
                                </form>
                            @else
                                <form method="post" action="{{ $formRoute }}" class="d-inline-block">
                                    @csrf
                                    <input type="hidden" name="date" value="{{ Date::parse($date->date)->toDateString() }}">
                                    <input type="hidden" name="availability" value="yes">
                                    <button type="submit" class="btn p-0 text-success">
                                        <i class="fas fa-3x fa-check-circle"></i>
                                    </button>
                                </form>
                                <form method="post" action="{{ $formRoute }}" class="d-inline-block">
                                    @csrf
                                    <input type="hidden" name="date" value="{{ Date::parse($date->date)->toDateString() }}">
                                    <input type="hidden" name="availability" value="no">
                                    <button type="submit" class="btn p-0 text-danger">
                                        <i class="fas fa-3x fa-times-circle"></i>
                                    </button>
                                </form>
                            @endif
                        </div>
                        <div class="col">
                            @foreach($date->polls as $poll)
                            <a href="{{ route('users.show', ['id' => $poll->user_id]) }}" class="avatar-container">
                                <img data-toggle="tooltip" title="{{ $poll->user->name }}" src="{{ $poll->user->photo }}" class="{{ $poll->availability }}">
                            </a>
                            @endforeach
                        </div>
                    </div>
                </li>
            @endforeach
            @can('edit', $meeting)
                <li class="list-group-item">
                    <div class="row new-date">
                        <div class="col-xl-3 col-lg-4">
                            <label for="new-date">{{ __('Propose date') }}</label>
                            <form method="post" action="{{ $formRoute }}">
                                <div class="input-group">
                                    <input class="form-control" type="date" name="date" id="new-date" value="{{ Date::tomorrow()->toDateString() }}">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="submit" >{{ __('Add') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </li>
            @endcan
        </ul>
    </div>
@endif