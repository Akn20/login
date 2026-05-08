@extends('layouts.admin')

@section('content')

<h5>Update Profile</h5>

<form method="POST" action="{{ route('admin.patient.portal.profile.update') }}">
    @csrf

    <input type="text" name="mobile" value="{{ $patient->mobile }}" class="form-control mb-2">

    <input type="email" name="email" value="{{ $patient->email }}" class="form-control mb-2">

    <textarea name="address" class="form-control mb-2">{{ $patient->address }}</textarea>

    <input type="text" name="emergency_contact" value="{{ $patient->emergency_contact }}" class="form-control mb-2">

    <button class="btn btn-primary">Update</button>
</form>

@endsection