<div class="modal fade" id="delete-circle" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form method="post" action="{{ route('circles.delete', ['id' => $circle->id]) }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('Delete circle') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{ __('Are you sure to delete this circle?') }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
                    <button type="submit" class="btn btn-danger">{{ __('Delete') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>