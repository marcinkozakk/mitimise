<div class="modal fade" id="add-circle" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form method="post" action="{{ route('circles.create') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('Create circle') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label text-md-right">
                            {{ __('Name') }}
                        </label>

                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control{{ $errors->has('name_circle') ? ' is-invalid' : '' }}" name="name_circle" value="{{ old('name_circle') }}" required autofocus>

                            @if ($errors->has('name_circle'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name_circle') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <fieldset class="form-group">
                        <div class="row">
                            <legend class="col-md-4 pt-0 col-form-label text-md-right">
                                {{ __('Visibility') }}
                            </legend>
                            <div class="col-md-8">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="is_private" id="private" value="1" checked>
                                    <label class="form-check-label" for="private">
                                        <i data-toggle="tooltip" title="{{ __('Visible only to you') }}"  class="fas fa-lock"></i>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="is_private" id="public" value="0">
                                    <label class="form-check-label" for="public">
                                        <i data-toggle="tooltip" title="{{ __('Visible to all members') }}" class="fas fa-users"></i>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
                    <button type="submit" class="btn btn-primary" name="create-circle">{{ __('Create') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>