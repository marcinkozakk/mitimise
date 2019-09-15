<input id="place-search" type="text" class="form-control mb-1" placeholder="{{ __('type place name...') }}">

<div id="map"></div>

<input id="place-name" type="text" class="my-1 form-control{{ $errors->has('place_name') ? ' is-invalid' : '' }}" name="place_name" value="{{ old('place_name') }}" placeholder="{{ __('Place name') }}">
<input id="place-address" type="text" class="mb-1 form-control{{ $errors->has('place_address') ? ' is-invalid' : '' }}" name="place_address" value="{{ old('place_address') }}" placeholder="{{ __('Place address') }}">
<div class="form-check">
    <input class="form-check-input" name="place_private" type="checkbox" value="1" id="defaultCheck2">
    <label class="form-check-label pl-1" for="defaultCheck2">
        {{ __('This address is private, only guests are able to see it') }}
    </label>
</div>
<input id="place-lat" name="place_lat" value="{{ old('place_lat') }}" type="hidden">
<input id="place-lng" name="place_lng" value="{{ old('place_lng') }}" type="hidden">