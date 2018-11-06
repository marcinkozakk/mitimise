<div class="card">
    <div class="card-header">Twoje kręgi</div>
    <div class="card-body">
        @if($circles->count() == 0)
            <p>Nie masz jeszcze żadnego kregu znajomych, utwórz go teraz:</p>
            @include('circles.add-modal')
        @endif
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add-circle">
            {{ __('Create circle') }}
        </button>
    </div>
</div>