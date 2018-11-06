@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="jumbotron">
                <h1 class="display-4">{{ __('Hello') }}, {{ Auth::user()->name }}!</h1>
            </div>
            @include('homeElements.circle')
        </div>
    </div>
</div>
@endsection
