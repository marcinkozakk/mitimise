@extends('layouts.app')

@php
$groupedGuests = $meeting->guests->groupBy('pivot.state');

//TODO: odwrócenie anulowania
@endphp

@section('content')
    <div class="container show-meeting">
        @include('meetings.partials.head')

        @can('viewGuests', $meeting)
            @include('meetings.partials.viewGuests')
        @else
            @can('setState', $meeting)
                @include('meetings.partials.setState')
            @endcan
        @endcan

        @include('meetings.partials.comments')

    </div>

    @can('revertCancelation', $meeting)
        @include('meetings.revert-modal')
    @endcan

    @can('comment', $meeting)
        @include('meetings.cant-modal')
        @include('meetings.delete-comment-modal')
    @endcan

    @can('edit', $meeting)
        @include('meetings.invite-modal')
        @include('meetings.edit-modal')
        @include('meetings.cancel-modal')
    @endcan
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