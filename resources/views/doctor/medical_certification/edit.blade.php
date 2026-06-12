@extends('layouts.admin')

@section('content')

<form action="{{ route('doctor.medical-certification.update', $record->id) }}"
      method="POST">

@csrf
@method('PUT')

@include('doctor.medical_certification.form')

</form>

@endsection