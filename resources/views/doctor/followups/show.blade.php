
@extends('layouts.admin')

@section('content')

<div class="container">

    <div class="card shadow-sm">

        <div class="card-header">

            <h4 class="mb-0">
                Follow-up Details
            </h4>

            <a href="{{ route('doctor.followups.index') }}"
               class="btn btn-sm btn-outline-primary">
                <i class="feather feather-arrow-left"></i> Back
            </a>

        </div>

        <div class="card-body">

            <table class="table table-bordered">

                <tr>

                    <th width="250">
                        Patient
                    </th>

                    <td>

                        {{ optional($followup->patient)->first_name }}
                        {{ optional($followup->patient)->last_name }}

                    </td>

                </tr>

                <tr>

                    <th>
                        Doctor
                    </th>

                    <td>

                        {{ optional($followup->doctor)->name }}

                    </td>

                </tr>

                <tr>

                    <th>
                        Follow-up Date
                    </th>

                    <td>

                        {{ $followup->follow_up_date }}

                    </td>

                </tr>

                <tr>

                    <th>
                        Status
                    </th>

                    <td>

                        {{ $followup->status }}

                    </td>

                </tr>

                <tr>

                    <th>
                        Remarks
                    </th>

                    <td>

                        {{ $followup->remarks }}

                    </td>

                </tr>

            </table>

            
        </div>

    </div>

</div>

@endsection

