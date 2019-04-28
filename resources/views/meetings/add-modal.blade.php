<div class="modal fade" id="add-meeting" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form method="post" action="{{ route('meetings.create') }}">
                @csrf
                @isset($circle)
                    <input type="hidden" name="circle_id" value="{{ $circle->id }}">
                @endisset
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('Create meeting') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label text-md-right">
                            {{ __('Name') }}
                        </label>

                        <div class="col-md-8">
                            <input id="name" type="text" class="form-control{{ $errors->has('name_meeting') ? ' is-invalid' : '' }}" name="name_meeting" value="{{ old('name_meeting') }}" required autofocus>

                            @if ($errors->has('name_meeting'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name_meeting') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="description" class="col-md-4 col-form-label text-md-right">
                            {{ __('Description') }}
                        </label>

                        <div class="col-md-8">
                            <textarea id="description" type="text" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" name="description">{{
                            old('description')
                            }}</textarea>

                            @if ($errors->has('description'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('description') }}</strong>
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
                                    <input class="form-check-input" type="radio" name="is_private" id="private_meeting" value="1" checked>
                                    <label class="form-check-label" for="private_meeting">
                                        <i data-toggle="tooltip" title="{{ __('Only you can view guests') }}"  class="fas fa-lock"></i>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="is_private" id="public_meeting" value="0">
                                    <label class="form-check-label" for="public_meeting">
                                        <i data-toggle="tooltip" title="{{ __('All can view everyone') }}" class="fas fa-users"></i>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </fieldset>

                    <div class="form-group row">
                        <label class="col-md-4 col-form-label text-md-right pt-0">
                            {{ __('Date') }}
                        </label>

                        <div class="col-md-8">
                            <div class="form-check">
                                <input class="form-check-input" name="null_date" type="checkbox" value="1" id="defaultCheck1">
                                <label class="form-check-label pl-1" for="defaultCheck1">
                                    {{ __('Don\'t set now') }}
                                </label>
                                <div class="form-group dates-group p-1 row">
                                    <div class="col-6">
                                        <label class="mb-0" for="starts_at">{{ __('Starts at') }}</label>
                                        <input class="form-control{{ $errors->has('starts_at') ? ' is-invalid' : '' }}" type="datetime-local" name="starts_at" id="starts_at" value="{{ date('Y-m-d\TH:i', strtotime('tomorrow 18:00')) }}">
                                        @if ($errors->has('starts_at'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('starts_at') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="col-6">
                                        <label class="mb-0" for="ends_at">{{ __('Ends at') }}</label>
                                        <input class="form-control{{ $errors->has('ends_at') ? ' is-invalid' : '' }}" type="datetime-local" name="ends_at" id="ends_at" value="{{ date('Y-m-d\TH:i', strtotime('tomorrow 23:00')) }}">
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

                    @include('meetings.partials.setPlace')

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('Create') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>