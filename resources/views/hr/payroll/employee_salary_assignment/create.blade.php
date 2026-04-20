@extends('layouts.admin')

@section('content')

<div class="card">
    <div class="card-body">

        {{-- ERROR MESSAGE --}}
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('hr.payroll.employee-salary-assignment.store') }}" method="POST">
            @csrf  

            @include('hr.payroll.employee_salary_assignment.form')
            <div class="d-flex justify-content-end mt-3">
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="{{ route('hr.payroll.employee-salary-assignment.index') }}" class="btn btn-light">Cancel</a>
            </div>

        </form>

    </div>
</div>

@endsection