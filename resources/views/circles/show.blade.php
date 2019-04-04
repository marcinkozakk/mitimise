@extends('layouts.app')

@section('content')

<div id="circle-container">
    @php
    $circles = $circle->members->count();
    if(Auth::user()->can('edit', $circle)) {
        $deg = 360 / ($circles + 1);
    } else {
        $deg = 360 / $circles;
    }
    $i = 0;
    @endphp
    <div class="d-flex flex-column align-items-center justify-content-center circle-summary">
        <h1>{{ $circle->name }}</h1>
        @can('edit', $circle)
            <div>
                @if($circle->is_private)
                    <i data-toggle="tooltip" title="{{ __('Visible only to you') }}"  class="fas fa-lock"></i>
                @else
                    <i data-toggle="tooltip" title="{{ __('Visible to all members') }}" class="fas fa-users"></i>
                @endif
                <a data-toggle="modal" data-target="#edit-circle">
                    <i data-toggle="tooltip" title="{{ __('Edit') }}" class="fas fa-edit m-2"></i>
                </a>
                <a data-toggle="modal" data-target="#delete-circle">
                    <i data-toggle="tooltip" title="{{ __('Delete') }}" class="fas fa-trash"></i>
                </a>
            </div>
        @endcan
    </div>
    @can('edit', $circle)
    <div class="avatar-container add-container" style="--endDeg:{{ $deg * $i }}deg">
        <a style="--endDeg:-{{ $deg * $i }}deg">
            <div data-toggle="tooltip" data-offset="0, 10%" title="{{ __('Add member') }}" class="add-wrap w-100">
                <img id="add" src="/images/plus-circle-solid.svg">
            </div>
        </a>
    </div>
    @endcan
    @while(++$i <= $circles)
        <div data-id="{{ $circle->members[$i - 1]->id }}" class="avatar-container" style="--endDeg:{{ $deg * $i }}deg">
            <a style="--endDeg:-{{ $deg * $i }}deg">
                <div data-toggle="tooltip" data-offset="0, 10%" title="{{ $circle->members[$i - 1]->name }}" class="avatar-wrap w-100">
                    <img {{ $circle->members[$i - 1]->id == $circle->owner->id ? 'class=you' : '' }} data-id="{{ $circle->members[$i - 1]->id }}" src="{{ $circle->members[$i - 1]->photo }}">
                </div>
            </a>
        </div>
    @endwhile
</div>
@include('circles.edit-modal')
@include('circles.delete-modal')
@endsection


@push('body-end')
<script>
    var derived = {
        circle_id: '{{ $circle->id }}',
        members_id: [{{ $circle->members->implode('id', ', ') }}],
        getPopContent: function (user_id) {
            return '<a href="/users/show/' + user_id + '" class="btn btn-block btn-primary text-white">{{ __('View profile') }}</a>'
            @can('edit', $circle)
                + '<a onclick="deleteMember(' + user_id + ')" data-id="' + user_id + '" class="btn btn-block btn-sm btn-danger text-white">{{ __('Remove form circle') }}</a>'
            @endcan
        ;}
    };
</script>
@endpush
