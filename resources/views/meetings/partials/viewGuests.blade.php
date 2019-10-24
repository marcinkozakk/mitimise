<div id="guests" class="row m-0">
    @can('setState', $meeting)
        <div class="col-12">
            <h4 class="text-center">
                {{ $meeting->guests->where('id', Auth::id())->first()->pivot->state == 'undecided' ?
                __('You haven\'t decided yet whether you are going to take part in this meeting') :
                __('You have decided that you are going') }}
            </h4>
        </div>
    @endcan
    <div class="col-lg-4 card p-0">
        <div class="card-header">{{ __('Going') }}</div>
        <div class="card-body row flex-grow-0">
            @foreach($groupedGuests['going'] as $guest)
                <a data-toggle="tooltip" title="{{ $guest->name }}" class="col-3 px-2 mb-3 avatar-wrap">
                    <img data-id="{{ $guest->id }}" class="avatar-border{{ $guest->id == Auth::id() ? ' you' : ''}}" src="{{ $guest->photo }}">
                </a>
            @endforeach
        </div>
    </div>
    <div class="col-lg-4 my-2 my-lg-0 text-center d-flex justify-content-center align-items-center flex-wrap align-content-center">
                    <span class="count green display-3">
                        {{ $groupedGuests['going']->count() }}
                    </span>
        <span class="p-1 display-4">{{ __('of') }}</span>
        <span class="count orange display-3">
                        {{ $meeting->guests->count() }}
                    </span>
        <span class="h1 mt-1">
                        {{ __('attending') }}
                    </span>
        @can('setState', $meeting)
            <div class="row w-100 my-1">
                <div class="col-md-6">
                    @if($meeting->guests->where('id', Auth::id())->first()->pivot->state == 'undecided')
                        <a href="{{ route('invitations.setState', ['id' => $meeting->id, 'state' => 'going']) }}" class="btn btn-block btn-going">
                            {{ __('I\'m going') }}
                        </a>
                    @else
                        <a href="{{ route('invitations.setState', ['id' => $meeting->id, 'state' => 'undecided']) }}" class="btn btn-block btn-undecided">
                            {{ __('I\'m undecided') }}
                        </a>
                    @endif
                </div>
                <div class="col-md-6">
                    <a data-toggle="modal" data-target="#cant-modal" class="btn btn-block btn-cant">
                        {{ __('I can\'t go') }}
                    </a>
                </div>
            </div>
        @endcan
    </div>
    <div class="col-lg-4 card p-0">
        <div class="card-header">{{ __('Undecided') }}</div>
        <div class="card-body row flex-grow-0">
            @isset($groupedGuests['undecided'])
            @foreach($groupedGuests['undecided'] as $guest)
                <a data-toggle="tooltip" title="{{ $guest->name }}" class="col-3 px-2 mb-3 avatar-wrap">
                    <img data-id="{{ $guest->id }}" class="avatar-border" src="{{ $guest->photo }}">
                </a>
            @endforeach
            @endif
        </div>
    </div>
</div>
