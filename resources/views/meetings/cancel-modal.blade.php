<div class="modal fade" id="cancel-meeting" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('Cancel meeting') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{ __('Are you sure to cancel this meeting?') }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Don\'t cancel') }}</button>
                <a href="{{ route('meetings.cancel', ['id' => $meeting->id]) }}" class="btn btn-danger">{{ __('Yes, I\'m sure') }}</a>
            </div>
        </div>
    </div>
</div>