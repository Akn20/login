@extends('layouts.admin')

@section('content')

<div class="container">
    <div class="card">
        <div class="card-header">
            <h4>Doctor Notes</h4>
        </div>

        <div class="card-body">

            @forelse($notes as $note)

                <div class="border p-3 mb-2 rounded">
                    <p>{{ $note->notes }}</p>

                    <small class="text-muted">
                        {{ $note->created_at }}
                    </small>
                </div>

            @empty

                <p>No permitted notes available</p>

            @endforelse

        </div>
    </div>
</div>

@endsection