@extends('layouts.app')

@php
$groupedGuests = $meeting->guests->groupBy('pivot.state');

//TODO: odwrócenie anulowania
@endphp

@section('content')
    <div class="container show-meeting">

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

        @can('viewGuests', $meeting)
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
                <div class="col-4 card p-0">
                    <div class="card-header">{{ __('Going') }}</div>
                    <div class="card-body row flex-grow-0">
                        @foreach($groupedGuests['going'] as $guest)
                            <a data-toggle="tooltip" title="{{ $guest->name }}" class="col-3 px-2 mb-3 avatar-wrap">
                                <img data-id="{{ $guest->id }}" class="avatar-border{{ $guest->id == Auth::id() ? ' you' : ''}}" src="{{ $guest->photo }}">
                            </a>
                        @endforeach
                    </div>
                </div>
                <div class="col-4 text-center d-flex justify-content-center align-items-center flex-wrap align-content-center">
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
                        <div class="row w-100">
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
                <div class="col-4 card p-0">
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
        @else
            @can('setState', $meeting)
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
            @endcan
        @endcan

    </div>
    @can('edit', $meeting)
        @include('meetings.invite-modal')
        @include('meetings.edit-modal')
        @include('meetings.cancel-modal')
    @endcan
    @include('meetings.cant-modal')
@endsection

@push('body-end')
@if($meeting->is_canceled)
    @include('meetings.locked-modal')
@endif
<script>
    var derived = {
        guests_id: [{{ $meeting->guests->implode('id', ', ') }}],
        getPopContent: function (user_id) {
            return '<a href="/users/show/' + user_id + '" class="btn btn-block btn-primary text-white">{{ __('View profile') }}</a>'
                @can('edit', $meeting)
                + '<a href="/invitations/delete/' + user_id + '/{{ $meeting->id }}" class="btn btn-block btn-sm btn-danger text-white">{{ __('Remove form meeting') }}</a>'
                @endcan
            ;}
    };
</script>
@endpush