@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-8">
                        {{ __('Notifications') }}
                    </div>
                    <div class="col-2">
                        {{ __('Created at') }}
                    </div>
                    <div class="col-2">
                        {{ __('Read at') }}
                    </div>
                </div>
            </div>
            <div class="list-group list-group-flush">
                @foreach($notifications as $notification)
                    <a
                            class="list-group-item list-group-item-action{{ $notification->read_at ? '' : ' list-group-item-info' }}"
                            href="{{ route('notifications.route', ['id' => $notification->id]) }}">
                        <div class="row">
                            <div class="col-1">
                                <i class="fas fa-{{ $notification->data['icon'] }}"></i>
                            </div>
                            <div class="col-7">
                                {{ __($notification->data['text'], [
                                    'doer' => $notification->data['doer'],
                                    'target' => $notification->data['target']
                                ]) }}
                            </div>
                            <div class="col-2">
                                {{ $notification->created_at->format('d.m.Y H:m') }}
                            </div>
                            <div class="col-2">
                                {{ $notification->read_at ? $notification->read_at->format('d.m.Y H:m') : '' }}
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
@endsection