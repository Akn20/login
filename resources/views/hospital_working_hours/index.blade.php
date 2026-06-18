@extends('layouts.admin')

@section('content')

<div class="main-content">

    <div class="page-header">
        <h4>Hospital Working Hours</h4>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">

        <div class="card-header d-flex justify-content-between">

            <h5>Hospital Working Hours List</h5>

            <a href="{{ route('hospital-working-hours.create') }}"
               class="btn btn-primary">

                <i class="feather-plus"></i>
                Add Working Hours

            </a>

        </div>

        <div class="card-body">

            <table class="table table-bordered table-striped">

                <thead>

                    <tr>
                        <th>ID</th>
                        <th>Opening Time</th>
                        <th>Closing Time</th>
                        <th>Break Start</th>
                        <th>Break End</th>
                        <th>24x7 Emergency</th>
                        <th>Status</th>
                        <th width="150">Actions</th>
                    </tr>

                </thead>

                <tbody>

                    @forelse($workingHours as $hour)

                    <tr>

                        <td>{{ $hour->id }}</td>

                        <td>{{ date('h:i A', strtotime($hour->opening_time)) }}</td>

                        <td>{{ date('h:i A', strtotime($hour->closing_time)) }}</td>

                        <td>
                            {{ $hour->break_start ? date('h:i A', strtotime($hour->break_start)) : '-' }}
                        </td>

                        <td>
                            {{ $hour->break_end ? date('h:i A', strtotime($hour->break_end)) : '-' }}
                        </td>

                        <td>

                            @if($hour->emergency_24x7)

                                <span class="badge bg-info">
                                    Yes
                                </span>

                            @else

                                <span class="badge bg-secondary">
                                    No
                                </span>

                            @endif

                        </td>

                        <td>

                            @if($hour->status == 'Active')

                                <span class="badge bg-success">
                                    Active
                                </span>

                            @else

                                <span class="badge bg-danger">
                                    Inactive
                                </span>

                            @endif

                        </td>

                        <td>

                            <div class="d-flex align-items-center gap-2">

                                <a href="{{ route('hospital-working-hours.show',$hour->id) }}"
                                   class="btn btn-sm btn-light border"
                                   title="View">

                                    <i class="feather-eye text-info"></i>

                                </a>

                                <a href="{{ route('hospital-working-hours.edit',$hour->id) }}"
                                   class="btn btn-sm btn-light border"
                                   title="Edit">

                                    <i class="feather-edit text-warning"></i>

                                </a>

                                <form action="{{ route('hospital-working-hours.destroy',$hour->id) }}"
                                      method="POST"
                                      style="display:inline-block;">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                    class="btn btn-sm btn-light border"
                                    title="Delete"
                                    onclick="return confirm('Are you sure you want to delete this working hours record?')">

                                    <i class="feather-trash-2 text-danger"></i>

                                </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="8" class="text-center">

                            No Working Hours Found

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection