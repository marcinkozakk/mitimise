<div class="form-group row">
    <label for="place-search" class="col-md-4 col-form-label text-md-right">
        {{ __('Place') }}
    </label>

    <div class="col-md-8" id="place-method">
        <button class="btn btn-primary btn-sm" type="button" data-toggle="collapse" data-target="#place-wizard" aria-expanded="false">
            Pomóż mi wybrać miejsce
        </button>
        <button class="btn btn-primary btn-sm" type="button" data-toggle="collapse" data-target="#place-custom" aria-expanded="false">
            Sam wybiorę miejsce
        </button>
        <div data-parent="#place-method" class="collapse" id="place-wizard">

        </div>
        <div data-parent="#place-method" class="collapse mt-2" id="place-custom">
            @include('meetings.partials.placeCustom')
        </div>
    </div>
</div>