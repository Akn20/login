@extends('layouts.admin')

@section('title', 'Consent History')

@section('content')
<div class="container-fluid">

    <div class="card">

        <div class="card-header">
            <h4>
                Consent History -
                {{ $patient->first_name }} {{ $patient->last_name }}
            </h4>
        </div>

        <div class="card-body table-responsive">

            <table class="table table-bordered">

                <thead>
                    <tr>
                        <th>#</th>
                        <th>Surgery</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($consents as $consent)

                        <tr>

                            <td>{{ $loop->iteration }}</td>

                            <td>
                                {{ $consent->surgery->surgery_type ?? '-' }}
                            </td>

                            <td>
                                {{ $consent->consent_status }}
                            </td>

                            <td>
                                {{ \Carbon\Carbon::parse($consent->consent_taken_at)->format('d M Y h:i A') }}
                            </td>

                            <td>
                                <a href="{{ route('consent.show', $consent->id) }}"
                                   class="btn btn-info btn-sm">
                                    View
                                </a>
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="5" class="text-center">
                                No history found.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>
    </div>
</div>
@endsection