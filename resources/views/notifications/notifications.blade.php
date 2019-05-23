@php
$notifications = Auth::user()->unreadNotifications;
$count = $notifications->count();
$isNew = $count > 0;
@endphp

<li class="notifications nav-item dropdown p-0 m-2 btn{{ $isNew ? ' btn-info' : '' }}">
    <a id="navbarDropdown" class="nav-link dropdown-toggle{{ $isNew ? ' text-white' : '' }} " href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
        <i class="fas fa-bell"></i>
        <span class="badge badge-light text-black-50 ml-1">
            {{ $count }}
        </span>
    </a>
    <div class="dropdown-menu dropdown-menu-right notifications-list" aria-labelledby="navbarDropdown">
        @foreach($notifications as $notification)
            <a class="dropdown-item" href="{{ route('notifications.route', ['id' => $notification->id]) }}">
                <div class="row">
                    <div class="col-2 text-center">
                        <i class="fas fa-{{ $notification->data['icon'] }}"></i>
                    </div>
                    <div class="col-10">
                        {{ __($notification->data['text'], [
                            'doer' => $notification->data['doer'],
                            'target' => $notification->data['target']
                        ]) }}
                    </div>
                </div>
            </a>
        @endforeach
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="{{ route('notifications.list') }}">
            {{ __('See all') }}
        </a>
    </div>
</li>
