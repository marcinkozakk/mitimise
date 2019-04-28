<div class="card-header">{{ __('Circles you are member of') }}</div>
<div class="list-group list-group-flush">
    @php
    $circles = $user->memberCircles;
    @endphp
    @if($circles->count() == 0)
        <div class="card-body p-0">
            <p class="list-group-item">{{ __('You aren\'t in any circle') }}</p>
        </div>
    @else
        @foreach($circles as $circle)
            <div class="list-group-item">
                <div class="row">
                    <div class="col-sm-4">
                        <h4 class="d-flex align-items-center mb-0 mt-1">
                            <a href="{{ route('circles.show', [$circle->id]) }}">
                                {{ $circle->name }}
                            </a>
                        </h4>
                    </div>
                    <div class="col-sm-8">
                        @foreach($circle->members as $member)
                            <a href="{{ route('users.show', ['id' => $member->id]) }}">
                                <img data-toggle="tooltip" title="{{ $member->name }}" class="avatar" src="{{ $member->photo }}">
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
    @endif
</div>
