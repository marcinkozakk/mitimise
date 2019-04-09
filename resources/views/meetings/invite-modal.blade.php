<div class="modal fade" id="invite-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('Invite') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body row">
                <div class="col-7">
                    <div class="input-group mb-1">
                        <input id="s" onkeypress="if(event.which == 13)searchUserForMeeting()" autofocus class="form-control" placeholder="{{ __('search...') }}" type="text">
                        <div class="input-group-append">
                            <button onclick="searchUserForMeeting()" class="btn btn-outline-info"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                    <ul id="search-result" class="list-group">
                    </ul>
                </div>
                <div class="col-5">
                    <div class="card">
                        <div class="card-header">
                            {{ __('Guest list') }}
                            <span class="badge badge-secondary guest-count">{{ $meeting->guests->count() }}</span>
                        </div>
                        <div class="card-body p-1">
                            <div class="guest-list">
                                @foreach($meeting->guests as $guest)
                                    <img data-toggle="tooltip" title="{{ $guest->name }}"  src="{{ $guest->photo }}">
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <form id="invite-form" method="post" action="{{ route('invitations.invite') }}">
                    @csrf
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('Invite') }}</button>
                    <input type="hidden" name="meeting_id" value="{{ $meeting->id }}">
                </form>
            </div>
        </div>
    </div>
</div>