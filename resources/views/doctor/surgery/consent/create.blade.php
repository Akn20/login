@extends('layouts.admin')

@section('title', 'Record Surgery Consent')

@section('content')

<div class="container-fluid">

    <div class="card">

        <div class="card-header d-flex justify-content-between align-items-center">

            <h4 class="mb-0">

                Record Surgery Consent

            </h4>

            <a href="{{ route('consent.index') }}"
               class="btn btn-secondary btn-sm">

                Back

            </a>

        </div>

        <div class="card-body">

            @if ($errors->any())

                <div class="alert alert-danger">

                    <ul class="mb-0">

                        @foreach ($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

            @endif

            <form action="{{ route('consent.store') }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf

                <div class="row">

                    {{-- Surgery Selection --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Select Surgery

                        </label>

                        <select name="surgery_id"
                                class="form-select"
                                required>

                            <option value="">

                                Select Surgery

                            </option>

                            @foreach($surgeries as $surgery)

                                <option value="{{ $surgery->id }}">

                                    {{ $surgery->surgery_type }}
                                    |
                                    {{ $surgery->patient->first_name ?? '' }}
                                    {{ $surgery->patient->last_name ?? '' }}
                                    |
                                    {{ $surgery->surgery_date }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    {{-- Consent Status --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Consent Status

                        </label>

                        <select name="consent_status"
                                class="form-select"
                                required>

                            <option value="">

                                Select Status

                            </option>

                            <option value="Granted">

                                Granted

                            </option>

                            <option value="Refused">

                                Refused

                            </option>

                            <option value="Pending">

                                Pending

                            </option>

                        </select>

                    </div>

                    {{-- Procedure Explained --}}
                    <div class="col-md-12 mb-3">

                        <label class="form-label">

                            Procedure Explained

                        </label>

                        <textarea name="procedure_explained"
                                  rows="3"
                                  class="form-control"></textarea>

                    </div>

                    {{-- Risks Explained --}}
                    <div class="col-md-12 mb-3">

                        <label class="form-label">

                            Risks Explained

                        </label>

                        <textarea name="risks_explained"
                                  rows="3"
                                  class="form-control"></textarea>

                    </div>

                    {{-- Remarks --}}
                    <div class="col-md-12 mb-3">

                        <label class="form-label">

                            Remarks

                        </label>

                        <textarea name="remarks"
                                  rows="3"
                                  class="form-control"></textarea>

                    </div>

                    {{-- Upload Document --}}
                    <div class="col-md-12 mb-3">

                        <label class="form-label">

                            Upload Consent Document

                        </label>

                        <input type="file"
                               name="document"
                               class="form-control">

                    </div>

                </div>

                {{-- Submit Buttons --}}
                <button type="submit"
                        class="btn btn-primary">

                    Save Consent

                </button>

                <a href="{{ route('consent.index') }}"
                   class="btn btn-secondary">

                    Cancel

                </a>

            </form>

        </div>

    </div>

</div>

@endsection