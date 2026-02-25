@extends('layouts.admin')
@section('page-title', 'Create Weekend Configuration | ' . config('app.name'))
@section('content')
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <h5 class="m-b-10">Create Weekend Configuration</h5>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.weekends.store') }}" method="POST">
            @csrf

            @include('admin.Leave_Management.Weekend.form')

        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const selectEl = document.getElementById('weekend-days-select');
    if (selectEl) {
        new TomSelect('#weekend-days-select', {
            plugins: ['remove_button'],
            maxItems: 7, // all days allowed
            closeAfterSelect: false,
            create: false,
            placeholder: 'Select weekend days',
        });
    }
});
</script>
@endpush