@extends('layouts.admin')

@section('content')

<div class="page-header">
    <h5 class="text-danger">Deleted Reports</h5>

    <a href="{{ route('admin.laboratory.report.index') }}" class="btn btn-light">
        Back
    </a>
</div>

<div class="card">
    <div class="card-body">

        <table class="table table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Sample</th>
                    <th>Deleted At</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse($reports as $report)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $report->sample->sample_id }}</td>
                        <td>{{ $report->deleted_at }}</td>

                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">

                                <!-- RESTORE -->
                                <form method="POST" action="{{ route('admin.laboratory.report.restore', $report->id) }}">
                                    @csrf
                                    @method('PUT')
                                    <button class="btn btn-outline-success btn-icon rounded-circle">
                                        <i class="feather-rotate-ccw"></i>
                                    </button>
                                </form>

                                <!-- FORCE DELETE -->
                                <form method="POST" action="{{ route('admin.laboratory.report.forceDelete', $report->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-outline-danger btn-icon rounded-circle">
                                        <i class="feather-trash-2"></i>
                                    </button>
                                </form>

                            </div>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">No Deleted Reports</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>
</div>

@endsection