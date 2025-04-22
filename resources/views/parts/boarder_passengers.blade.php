@php

    use App\Models\Data;

@endphp

<div class="grid">
    <h3 class="card-title mb-2"><b>
          {{__('messages.boarder_passengers')}}
        </b></h3>

    <table class="table table-striped table-bordered passengers-table">
            @include('parts.list_passengers')
    </table>
</div>
