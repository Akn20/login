@extends('layouts.admin')

@section(
    'page-title',
    'Create Statutory Compliance | ' . config('app.name')
)

@section('content')

<div class="nxl-content">

    <div class="page-header mb-4 d-flex justify-content-between align-items-center">

        <div>

            <h5 class="mb-1">
                Create Statutory Compliance
            </h5>

        </div>

        <a
            href="{{ route('hr.statutory-compliance.index') }}"
            class="btn btn-light"
        >
            Back
        </a>

    </div>

    <div class="card">

        <div class="card-body">

         <form
    action="{{ route('hr.statutory-compliance.store') }}"
    method="POST"
    enctype="multipart/form-data"
>

                @csrf

                @include(
                    'hr.statutory_compliance.form'
                )

                <div class="mt-4">

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        Save
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection