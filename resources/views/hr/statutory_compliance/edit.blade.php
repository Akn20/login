@extends('layouts.admin')

@section(
    'page-title',
    'Edit Statutory Compliance | ' . config('app.name')
)

@section('content')

<div class="nxl-content">

    <div class="page-header mb-4 d-flex justify-content-between align-items-center">

        <div>

            <h5 class="mb-1">
                Edit Statutory Compliance
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
    action="{{ route('hr.statutory-compliance.update', $record->id) }}"
    method="POST"
    enctype="multipart/form-data"
>

                @csrf
                @method('PUT')

                @include(
                    'hr.statutory_compliance.form'
                )

                <div class="mt-4">

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        Update
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection