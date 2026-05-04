@extends('layouts.admin')

@section('title', 'View Data Usage Consent')

@section('content')

<div class="container-fluid">

    <div class="card">

        <div class="card-header d-flex justify-content-between">

            <h4>Consent Details</h4>

            <a href="{{ route('admin.data-consent.index') }}"
               class="btn btn-secondary btn-sm">

                Back

            </a>

        </div>

        <div class="card-body">

            <table class="table table-bordered">

                <tr>

                    <th width="250">

                        Patient

                    </th>

                    <td>

                        {{ $consent->patient->patient_code }}
                        -
                        {{ $consent->patient->first_name }}
                        {{ $consent->patient->last_name }}

                    </td>

                </tr>

                <tr>

                    <th>Purpose</th>

                    <td>

                        {{ $consent->purpose }}

                    </td>

                </tr>

                <tr>

                    <th>Status</th>

                    <td>

                        {{ $consent->consent_status }}

                    </td>

                </tr>

                <tr>

                    <th>Remarks</th>

                    <td>

                        {{ $consent->remarks }}

                    </td>

                </tr>

                <tr>

                    <th>Consent Date</th>

                    <td>

                        {{ \Carbon\Carbon::parse($consent->consent_taken_at)->format('d M Y h:i A') }}

                    </td>

                </tr>

                <tr>

                    <th>Document</th>

                    <td>

                        @if($consent->document_path)

                            <a href="{{ asset('storage/' . $consent->document_path) }}"
                               target="_blank"
                               class="btn btn-success btn-sm">

                                View Document

                            </a>

                        @else

                            No Document Uploaded

                        @endif

                    </td>

                </tr>

            </table>

        </div>

    </div>

</div>

@endsection