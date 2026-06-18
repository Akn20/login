@extends('layouts.admin')

@section('content')

<div class="main-content">

    <div class="card">

        <div class="card-header">
            <h4>Hospital Working Hours Details</h4>
        </div>

        <div class="card-body">

            <table class="table table-bordered">

                <tr>
                    <th width="250">Opening Time</th>
                    <td>{{ date('h:i A', strtotime($workingHour->opening_time)) }}</td>
                </tr>

                <tr>
                    <th>Closing Time</th>
                    <td>{{ date('h:i A', strtotime($workingHour->closing_time)) }}</td>
                </tr>

                <tr>
                    <th>Break Start</th>
                    <td>
                        {{ $workingHour->break_start ? date('h:i A', strtotime($workingHour->break_start)) : '-' }}
                    </td>
                </tr>

                <tr>
                    <th>Break End</th>
                    <td>
                        {{ $workingHour->break_end ? date('h:i A', strtotime($workingHour->break_end)) : '-' }}
                    </td>
                </tr>

                <tr>
                    <th>24x7 Emergency</th>
                    <td>
                        {{ $workingHour->emergency_24x7 ? 'Yes' : 'No' }}
                    </td>
                </tr>

                <tr>
                    <th>Status</th>
                    <td>

                        @if($workingHour->status == 'Active')

                            <span class="badge bg-success">
                                Active
                            </span>

                        @else

                            <span class="badge bg-danger">
                                Inactive
                            </span>

                        @endif

                    </td>
                </tr>

            </table>

            <a href="{{ route('hospital-working-hours.index') }}"
               class="btn btn-secondary">

                Back

            </a>

        </div>

    </div>

</div>

@endsection