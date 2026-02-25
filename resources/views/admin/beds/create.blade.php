@extends('layouts.admin')

@section('page-title', 'Add Bed | ' . config('app.name'))

@section('content')

<div class="container">
    <div class="card">
        <div class="card-header">
            <h4>Add New Bed</h4>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.beds.store') }}" method="POST">
                @csrf

                @include('admin.beds.form')

               
            </form>
        </div>
    </div>
</div>

@endsection


@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {

    const wardSelect = document.querySelector('select[name="ward_id"]');
    const bedCodeInput = document.getElementById('bed_code');

    console.log("Script Loaded"); // debug check

    if (!wardSelect) {
        console.log("Ward select not found");
        return;
    }

    wardSelect.addEventListener("change", function () {

        console.log("Ward changed:", this.value); // debug check

        if (!this.value) return;

        fetch("/admin/beds/generate-code/" + this.value)
            .then(response => response.json())
            .then(data => {
                console.log("Generated Code:", data.code);
                bedCodeInput.value = data.code;
            })
            .catch(error => console.error("Error:", error));

    });

});
</script>
@endpush