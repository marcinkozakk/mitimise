@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.min.css">
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.js"></script>
@endpush

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card mb-3">
                    <div class="card-header">{{ __('Your photo') }}</div>
                    <div class="card-body">
                        @if(\Illuminate\Support\Facades\Auth::user()->photo)
                            <div class="text-center">
                                <img alt="Your photo" src="{{ Auth::user()->photo }}">
                            </div>
                        @else
                            Nie masz jeszcze zdjęcia. Dodaj je teraz, aby inni mogli cię rozpoznać.
                        @endif
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-header">{{ __('Edit photo') }}</div>
                    <div class="card-body ">
                        <div id="image-picker">
                            <form class="justify-content-center d-flex mb-3" method="POST" action="">
                                @csrf
                                <input type="file" id="photo" accept="image/*" class="d-none">
                                <label for="photo">Drag or click here to select image</label>
                            </form>
                            <div class="crop-container d-none">
                                <div id="crop"></div>
                                <button id="upload" class="btn btn-primary btn-block">Upload</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection