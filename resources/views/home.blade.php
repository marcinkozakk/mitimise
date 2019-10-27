@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="jumbotron">
                    <h1>{{ __('Hello') }}, {{ Auth::user()->name }}!</h1>
                </div>
                <div class="card circles-list mb-4">
                    @include('homeElements.circles')
                    @include('homeElements.memberCircles')
                </div>
                <div class="card mb-4">
                    @include('homeElements.meetings')
                    @include('homeElements.meetingsInvited')
                </div>
            </div>
        </div>
    </div>
@endsection
