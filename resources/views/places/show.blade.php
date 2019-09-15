@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card mb-4">
            <div class="card-header">
                {{ __('Miejsca w których odbędą się najbliższe spotkania') }}
            </div>

            <div class="list-group list-group-flush">
                @forelse($incomingPlaces as $place)
                    <div class="list-group-item">
                        <div class="row">
                            <div class="col-8">
                                <a href="#" class="name mb-0">
                                    {{ $place->name }}
                                </a>
                                <p class="mb-0 text-muted address">
                                    {{ $place->address }}
                                </p>
                                <p class="d-none id">
                                    {{ $place->id }}
                                </p>
                            </div>
                            <div class="col-2 align-self-center">
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="list-group-item">
                        {{ __('No places') }}
                    </div>
                @endforelse
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                {{ __('Miejsca w których byłeś podczas spotkań') }}
            </div>

            <div class="list-group list-group-flush">
                @forelse($pastPlaces as $place)
                    <div class="list-group-item">
                        <div class="row">
                            <div class="col-8">
                                <a href="#" class="name mb-0">
                                    {{ $place->name }}
                                </a>
                                <p class="mb-0 text-muted address">
                                    {{ $place->address }}
                                </p>
                                <p class="d-none id">
                                    {{ $place->id }}
                                </p>
                            </div>
                            <div class="col-2 align-self-center">
                                @if($place->isReviewed)
                                    <a href="#">
                                        {{ __('Oceniłeś na ') }}
                                        {{ $place->userRewiew->stars }}
                                        <i class="fas fa-star"></i>
                                    </a>
                                @else
                                    <button type="button" class="btn btn-link" data-toggle="modal" data-target="#add-review">
                                        {{ __('Write a review') }}
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="list-group-item">
                        {{ __('No places') }}
                    </div>
                @endforelse
            </div>
        </div>

    </div>
@include('reviews.add-modal')

@endsection

