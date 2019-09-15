<div class="modal fade" id="add-review" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('Write a review') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <h5 id="name"></h5>
                <p id="address"></p>
                <form>
                    @csrf
                    <input type="hidden" name="place_id" id="id">

                    <div class="form-group">
                        <label>
                            {{ __('Rating') }}:
                        </label>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>