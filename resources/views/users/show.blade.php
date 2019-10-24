@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-4">
                        <img src="{{ $user->photo }}">
                    </div>
                    <div class="col-sm-8 d-flex align-items-center">
                        <h2 class="display-3 text-center">{{ $user->name }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection