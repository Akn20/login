@extends('layouts.admin')

@section('content')

<div class="nxl-content">

    <div class="page-header d-flex justify-content-between">
        <h5>Scan Requests</h5>

        <a href="{{ route('admin.radiology.scan-requests.create') }}" class="btn btn-primary">
            Add Request
        </a>
    </div>

    <div class="card">
        <div class="card-body">

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Patient</th>
                        <th>Scan Type</th>
                        <th>Body Part</th>
                        <th>Priority</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($requests as $key => $req)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>
                            {{ $req->patient->first_name ?? '' }} {{ $req->patient->last_name ?? '' }}
                        </td>
                        <td>{{ $req->scanType->name }}</td>
                        <td>{{ $req->body_part }}</td>
                        <td>{{ $req->priority }}</td>
                        <td>{{ $req->status }}</td>

                        <td class="text-end">
                            <div class="hstack gap-2 justify-content-end">

                                {{-- Edit --}}
                                <a href="{{ route('admin.radiology.scan-requests.edit', $req->id) }}"
                                    class="avatar-text avatar-md action-icon action-edit">
                                    <i class="feather-edit"></i>
                                </a>

                                {{-- Delete --}}
                                <form action="{{ route('admin.radiology.scan-requests.delete', $req->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this request?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="avatar-text avatar-md action-icon action-delete">
                                        <i class="feather-trash-2"></i>
                                    </button>
                                </form>

                            </div>
                        </td>

                    </tr>
                    @endforeach
                </tbody>

            </table>

        </div>
    </div>

</div>

@endsection