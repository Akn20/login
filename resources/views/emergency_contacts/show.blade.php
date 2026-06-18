@extends('layouts.admin')

@section('content')

<div class="main-content">

    <div class="card">

        <div class="card-header">
            <h4>Emergency Contact Details</h4>
        </div>

        <div class="card-body">

            <table class="table table-bordered">

                <tr>
                    <th width="250">Contact Type</th>
                    <td>{{ $contact->contact_type }}</td>
                </tr>

                <tr>
                    <th>Contact Name</th>
                    <td>{{ $contact->contact_name }}</td>
                </tr>

                <tr>
                    <th>Mobile Number</th>
                    <td>{{ $contact->mobile_no }}</td>
                </tr>

                <tr>
                    <th>Alternate Number</th>
                    <td>{{ $contact->alternate_no }}</td>
                </tr>

                <tr>
                    <th>Email</th>
                    <td>{{ $contact->email }}</td>
                </tr>

                <tr>
                    <th>Address</th>
                    <td>{{ $contact->address }}</td>
                </tr>

                <tr>
                    <th>Status</th>
                    <td>
                        @if($contact->status == 'Active')
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

            <a href="{{ route('emergency-contacts.index') }}"
               class="btn btn-secondary">
                Back
            </a>

        </div>

    </div>

</div>

@endsection