@extends('layouts.admin')

@section('page-title', 'Edit Statutory Contribution')

@section('content')

<div class="row">

<div class="col-12">

<div class="card stretch stretch-full">

    <!-- HEADER -->

    <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">

        <!-- LEFT SIDE -->
        <div>

            <h5 class="mb-1">
                Edit Statutory Contribution
            </h5>

            <ul class="breadcrumb mb-0">

                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dashboard') }}">
                        Dashboard
                    </a>
                </li>

                <li class="breadcrumb-item">
                    <a href="{{ route('hr.payroll.statutory-contribution.index') }}">
                        Statutory Contribution
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
                    form="statutoryForm"
                    class="btn btn-primary">

                Save

            </button>

            <!-- CANCEL -->
            <a href="{{ route('hr.payroll.statutory-contribution.index') }}"
               class="btn btn-secondary">

                Cancel

            </a>

        </div>

    </div>



    <!-- BODY -->

    <div class="card-body">

        <form 
            id="statutoryForm"
            action="{{ route('hr.payroll.statutory-contribution.update', $statutoryContribution->id) }}"
            method="POST"
        >

            @csrf
            @method('PUT')

            {{-- Reuse Form --}}
            @include('hr.payroll.statutory_contribution.form')

        </form>

    </div>


</div>

</div>

</div>

@endsection