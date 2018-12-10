<div class="form-group row">
    <label for="place-search" class="col-md-4 col-form-label text-md-right">
        {{ __('Place') }}
    </label>

    <div class="col-md-8 input">
        <input id="place-search" type="text" class="form-control" placeholder="{{ __('type place name...') }}">
    </div>
</div>
<div class="row mb-1">
    <div class="offset-md-4 col-md-8">
        <div id="map"></div>
    </div>
</div>
<div class="form-group row">
    <div class="offset-md-4 col-md-8">
        <input id="place-name" type="text" class="mb-1 form-control{{ $errors->has('place_name') ? ' is-invalid' : '' }}" name="place_name" value="{{ $meeting->place ? $meeting->place->name : '' }}" placeholder="{{ __('Place name') }}">
        <input id="place-address" type="text" class="mb-1 form-control{{ $errors->has('place_address') ? ' is-invalid' : '' }}" name="place_address" value="{{ $meeting->place ? $meeting->place->address : '' }}" placeholder="{{ __('Place address') }}">
        <div class="form-check">
            <input class="form-check-input" name="place_private" type="checkbox" value="1" id="defaultCheck2">
            <label class="form-check-label pl-1" for="defaultCheck2">
                {{ __('This address is private, only guests are able to see it') }}
            </label>
        </div>
        <input id="place-lat" name="place_lat" value="{{ $meeting->place ? $meeting->place->lat : '' }}" type="hidden">
        <input id="place-lng" name="place_lng" value="{{ $meeting->place ? $meeting->place->lng : '' }}" type="hidden">
    </div>
</div>