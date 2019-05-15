@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.min.css">
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.js"></script>
@if(Session::has('photo_url'))
    <script>
        var photo_url = '{!! Session::get('photo_url') !!}';
    </script>
@endif
@endpush

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">

                <div class="card mb-3">
                    <div class="card-header">{{ __('Edit photo') }}</div>
                    <div class="card-body text-center">

                        <a class="btn btn-fb mb-4" href="{{ route('facebook.picture') }}">
                            <i class="fab fa-facebook-square mr-2"></i>
                            {{ __('Import Facebook Picture') }}
                        </a>

                        <div id="image-picker">
                            <form class="justify-content-center d-flex mb-3" method="POST" action="">
                                @csrf
                                <input type="file" id="photo" accept="image/*" class="d-none">
                                <label for="photo">{{ __('Drag or click here to select image') }}</label>
                            </form>
                            <div class="crop-container d-none">
                                <div id="crop"></div>
                                <button id="upload" class="btn btn-primary btn-block">{{ __('Change') }}</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-header">{{ __('Your photo') }}</div>
                    <div class="card-body">
                        @if(\Illuminate\Support\Facades\Auth::user()->photo)
                            <div class="text-center">
                                <img alt="Your photo" src="{{ Auth::user()->photo }}">
                            </div>
                        @else
                            {{ __('You don\'t have a profile photo. Add it now, so others could recognize you') }}
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection