@extends('layouts.admin')

@section('page-title', 'Edit Rate Employee Mapping')

@section('content')

<div class="row">

<div class="col-12">

<div class="card stretch stretch-full">

    <!-- HEADER -->

    <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">

        <!-- LEFT SIDE -->

        <div>

            <h5 class="mb-1">
                Edit Rate Employee Mapping
            </h5>

            <ul class="breadcrumb mb-0">

                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dashboard') }}">
                        Dashboard
                    </a>
                </li>

                <li class="breadcrumb-item">
                    <a href="{{ route('hr.payroll.rate-employee-mapping.index') }}">
                        Rate Employee Mapping
                    </a>
                </li>

                <li class="breadcrumb-item active">
                    Edit
                </li>

            </ul>

        </div>


        <!-- RIGHT SIDE BUTTONS -->

        <div class="d-flex align-items-center gap-2 flex-nowrap">

            <!-- SAVE -->

            <button type="submit"
                    form="rateMappingForm"
                    class="btn btn-primary">

                Save

            </button>


            <!-- CANCEL -->

            <a href="{{ route('hr.payroll.rate-employee-mapping.index') }}"
               class="btn btn-secondary">

                Cancel

            </a>

        </div>

    </div>



    <!-- BODY -->

    <div class="card-body">

        <form 
            id="rateMappingForm"
            action="{{ route('hr.payroll.rate-employee-mapping.update', $rateMapping->id) }}"
            method="POST"
        >

            @csrf
            @method('PUT')

            {{-- Reuse Form --}}
            @include('hr.payroll.rate_employee_mapping.form')

        </form>

    </div>


</div>

</div>

</div>

@endsection