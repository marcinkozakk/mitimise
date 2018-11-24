<div class="modal fade" id="delete-comment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('Delete comment') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{ __('Are you sure to delete this comment?') }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
                <form action="{{ route('comments.delete') }}" method="post">
                    @csrf
                    <input type="hidden" name="meeting_id" value="{{ $meeting->id }}">
                    <input type="hidden" name="comment_id" value="">
                    <button type="submit" class="btn btn-danger">{{ __('Delete') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>