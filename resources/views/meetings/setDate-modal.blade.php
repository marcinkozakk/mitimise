<div class="modal fade" id="setDate-meeting" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form method="post" action="{{ route('meetings.setDate', ['id' => $meeting->id]) }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('Set date') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-md-4 col-form-label text-md-right pt-0">
                            {{ __('Date') }}
                        </label>

                        <div class="col-md-8">
                            <div class="form-check">
                                <div class="form-group dates-group p-1">
                                    <label class="mb-0" for="starts_at">{{ __('Starts at') }}</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="date_starts_at"></span>
                                        </div>
                                        <input type="hidden" name="date_starts_at" value="">
                                        <input class="form-control{{ $errors->has('starts_at') ? ' is-invalid' : '' }}" type="time" name="time_starts_at" id="starts_at" value="18:00">
                                    </div>
                                    @if ($errors->has('starts_at'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('starts_at') }}</strong>
                                        </span>
                                    @endif

                                    <label class="mb-0" for="ends_at">{{ __('Ends at') }}</label>
                                    <input class="form-control{{ $errors->has('ends_at') ? ' is-invalid' : '' }}" type="datetime-local" name="ends_at" id="ends_at" value="">
                                    @if ($errors->has('ends_at'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('ends_at') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('Edit') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>