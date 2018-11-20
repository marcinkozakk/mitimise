<div class="card-header">{{ __('Your circles') }}</div>
<div class="list-group list-group-flush">
    @php
        $circles = $user->circles;
    @endphp
    @if($circles->count() == 0)
        <p class="list-group-item">{{ __('You haven\'t created any circle yet, create it now:') }}</p>
    @else
        @foreach($circles as $circle)
            <div class="list-group-item">
                <div class="row">
                    <div class="col-sm-4">
                        <h4 class="d-flex align-items-center mb-0 mt-1">
                            <a href="{{ route('circles.show', [$circle->id]) }}">
                                {{ $circle->name }}
                            </a>
                            @if($circle->is_private)
                                <i data-toggle="tooltip" title="{{ __('Visible only to you') }}"  class="fas fa-lock font-xx-small ml-1"></i>
                            @endif
                        </h4>
                    </div>
                    <div class="col-sm-8">
                        @foreach($circle->members as $member)
                            <a href="{{ route('users.show', ['id' => $member->id]) }}">
                                <img data-toggle="tooltip" title="{{ $member->name }}"  class="avatar" src="{{ $member->photo }}">
                            </a>
                        @endforeach
                        <a href="{{ route('circles.show', [$circle->id]) }}">
                            <i data-toggle="tooltip" title="{{ __('Add friend to this circle') }}" class="fas fa-plus-circle fa-2x"></i>
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
    <button type="button" class="btn btn-primary m-4" data-toggle="modal" data-target="#add-circle">
        {{ __('Create circle') }}
    </button>
</div>
@include('circles.add-modal')
