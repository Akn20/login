@extends('layouts.admin')

@section('title', 'View Patient Alert')

@section('content')

<div class="container-fluid">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">

        <h4 class="mb-0">Patient Alert Details</h4>

        <a href="{{ route('patient-alerts.index') }}"
            class="btn btn-secondary">
            Back
        </a>

    </div>

    <div class="row justify-content-center">

        <div class="col-lg-10 col-xl-9 mx-auto">

            <div class="card shadow-sm border-0">

                <div class="card-body p-4">

                    <table class="table table-bordered align-middle mb-0">

                        <tr>
                            <th width="250" class="bg-light">
                                Patient Name
                            </th>

                            <td>
                                {{ $alert->patient->first_name ?? '' }}
                                {{ $alert->patient->last_name ?? '' }}
                            </td>
                        </tr>

                        <tr>
                            <th class="bg-light">
                                Alert Type
                            </th>

                            <td>
                                {{ ucfirst($alert->alert_type) }}
                            </td>
                        </tr>

                        <tr>
                            <th class="bg-light">
                                Title
                            </th>

                            <td>
                                {{ $alert->title }}
                            </td>
                        </tr>

                        <tr>
                            <th class="bg-light">
                                Message
                            </th>

                            <td>
                                {{ $alert->message }}
                            </td>
                        </tr>

                        <tr>
                            <th class="bg-light">
                                Alert Date
                            </th>

                            <td>
                                {{ $alert->alert_date
                                    ? \Carbon\Carbon::parse($alert->alert_date)->format('d M Y h:i A')
                                    : 'N/A'
                                }}
                            </td>
                        </tr>

                        <tr>
                            <th class="bg-light">
                                Read Status
                            </th>

                            <td>
                                @if($alert->is_read)

                                    <span class="badge bg-success">
                                        Read
                                    </span>

                                @else

                                    <span class="badge bg-primary">
                                        Unread
                                    </span>

                                @endif
                            </td>
                        </tr>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection