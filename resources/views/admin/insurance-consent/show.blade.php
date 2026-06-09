@extends('layouts.admin')

@section('title', 'Insurance Consent Details')

@section('content')

<div class="container-fluid">

    <div class="card">

        <div class="card-header d-flex justify-content-between align-items-center">

            <h4 class="mb-0">

                Insurance Consent Details

            </h4>

            <a href="{{ route('admin.insurance-consent.index') }}"
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

                        {{ $consent->patient->first_name ?? '' }}
                        {{ $consent->patient->last_name ?? '' }}

                    </td>

                </tr>

                <tr>

                    <th>

                        Insurance

                    </th>

                    <td>

                        {{ $consent->insurance->provider_name ?? '' }}

                    </td>

                </tr>

                <tr>

                    <th>

                        Policy Number

                    </th>

                    <td>

                        {{ $consent->insurance->policy_number ?? '' }}

                    </td>

                </tr>

                <tr>

                    <th>

                        Status

                    </th>

                    <td>

                        {{ $consent->consent_status }}

                    </td>

                </tr>

                <tr>

                    <th>

                        Consent Date

                    </th>

                    <td>

                        {{ optional($consent->consent_given_at)->format('d M Y h:i A') }}

                    </td>

                </tr>

                <tr>

                    <th>

                        Consent Text

                    </th>

                    <td>

                        {{ $consent->consent_text }}

                    </td>

                </tr>

                <tr>

                    <th>

                        Document

                    </th>

                    <td>

                        @if($consent->document)

                            <a href="{{ asset('storage/' . $consent->document) }}"
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