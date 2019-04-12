<div class="row w-100">
    <div class="col-12">
        <h4 class="text-center">
            {{ $meeting->guests->where('id', Auth::id())->first()->pivot->state == 'undecided' ?
            __('You haven\'t decided yet whether you are going to take part in this meeting') :
            __('You have decided that you are going') }}
        </h4>
    </div>
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
