@extends('layouts.admin')

@section('page-title', 'Edit Training & Certification | ' . config('app.name'))

@section('content')

<div class="nxl-content">

    <div class="page-header d-flex align-items-center justify-content-between mb-5">

        <div class="page-header-title">

            <h5 class="mb-0">
                Edit Training & Certification
            </h5>

        </div>

    </div>

    <div class="row justify-content-center mt-4">

        <div class="col-12 col-md-10 col-lg-10">

            <div class="card shadow-sm">

                <div class="card-body">

                    <form
                        method="POST"
                        action="{{ route('hr.training-certification-tracking.update', $record->id) }}"
                        enctype="multipart/form-data"
                    >

                        @csrf
                        @method('PUT')

                        @include(
                            'hr.trainingCertificationTracking.form'
                        )

                        {{-- Current Attachment --}}
                        @if($record->attachment)

                            <div class="mb-4">

                                <label class="form-label">
                                    Current Attachment
                                </label>

                                <br>

                                <a
                                    href="{{ asset('storage/'.$record->attachment) }}"
                                    target="_blank"
                                >
                                    View Attachment
                                </a>

                            </div>

                        @endif

                        <div class="d-flex gap-2">

                            <button
                                type="submit"
                                class="btn btn-primary"
                            >
                                Update
                            </button>

                            <a
                                href="{{ route('hr.training-certification-tracking.index') }}"
                                class="btn btn-outline-secondary"
                            >
                                Cancel
                            </a>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection