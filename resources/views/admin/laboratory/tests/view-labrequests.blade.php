@extends('layouts.admin')

@section('content')

    <div class="container-fluid">

        <div class="card">

            <div class="card-header">
                <h4>Lab Test Requests</h4>
            </div>

            <div class="card-body">

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <table class="table table-bordered table-striped">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Patient Name</th>
                            <th>Test Name</th>
                            <th>Priority</th>
                            <th>Status</th>
                            <th>Consultation Date</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($labRequests as $index => $labRequest)

                            <tr>

                                <td>{{ $index + 1 }}</td>

                                <td>
                                    {{ $labRequest->patient->first_name ?? 'N/A' }}
                                </td>

                                <td>
                                    {{ $labRequest->test_name }}
                                </td>

                                <td>

                                    @if($labRequest->priority == 'routine')
                                        <span class="badge bg-secondary">Routine</span>

                                    @elseif($labRequest->priority == 'urgent')
                                        <span class="badge bg-warning text-dark">Urgent</span>

                                    @elseif($labRequest->priority == 'stat')
                                        <span class="badge bg-danger">STAT</span>

                                    @endif

                                </td>

                                <td>

                                    @if($labRequest->status == 'pending')
                                        <span class="badge bg-warning text-dark">Pending</span>

                                    @elseif($labRequest->status == 'in_progress')
                                        <span class="badge bg-info">In Progress</span>

                                    @elseif($labRequest->status == 'completed')
                                        <span class="badge bg-success">Completed</span>

                                    @endif

                                </td>

                                <td>
                                    {{ $labRequest->created_at->format('d M Y') }}
                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="6" class="text-center">
                                    No Lab Requests Found
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

@endsection