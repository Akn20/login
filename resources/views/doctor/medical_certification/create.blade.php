@extends('layouts.admin')

@section('content')

<form action="{{ route('doctor.medical-certification.store') }}"
      method="POST">

@csrf

@include('doctor.medical_certification.form')

</form>

@endsection