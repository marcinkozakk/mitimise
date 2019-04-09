<div class="card circles-list mb-2">
    <div class="card-header">{{ __('Circles you are member of') }}</div>
    <div class="card-body">
        @php
        $circles = $user->memberCircles;
        @endphp
        @if($circles->count() == 0)
            <p>{{ __('You aren\'t in any circle') }}</p>
        @else
            @foreach($circles as $circle)
                <div class="row p-2">
                    <div class="col-sm-4">
                        <h4 class="d-flex align-items-center">
                            <a href="{{ route('circles.show', [$circle->id]) }}">
                                {{ $circle->name }}
                            </a>
                        </h4>
                    </div>
                    <div class="col-sm-8">
                        @foreach($circle->members as $member)
                            <a href="{{ route('users.show', ['id' => $member->id]) }}">
                                <img data-toggle="tooltip" title="{{ $member->name }}"  class="avatar" src="{{ $member->photo }}">
                            </a>
                        @endforeach
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>