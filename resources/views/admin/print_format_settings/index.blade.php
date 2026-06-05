@extends('layouts.admin')

@section('content')

<div class="main-content">

    <div class="page-header">
        <h4>Print Format Settings</h4>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">

        <div class="card-header d-flex justify-content-between">

            <h5>Print Format List</h5>

            <a href="{{ route('print-format-settings.create') }}"
               class="btn btn-primary">

                <i class="feather-plus"></i>
                Add Format

            </a>

        </div>

        <div class="card-body">

            <table class="table table-bordered table-striped">

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Hospital Name</th>
                        <th>Paper Size</th>
                        <th>Orientation</th>
                        <th>Status</th>
                        <th width="150">Actions</th>
                    </tr>
                </thead>

                <tbody>

                @forelse($formats as $format)

                    <tr>

                        <td>{{ $format->id }}</td>
                        <td>{{ $format->hospital_name }}</td>
                        <td>{{ $format->paper_size }}</td>
                        <td>{{ $format->orientation }}</td>

                        <td>
                            @if($format->status == 'Active')
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-danger">Inactive</span>
                            @endif
                        </td>

                        <td>

                            <div class="d-flex align-items-center gap-2">

                                <a href="{{ route('print-format-settings.show',$format->id) }}"
                                   class="btn btn-sm btn-light border">
                                    <i class="feather-eye text-info"></i>
                                </a>

                                <a href="{{ route('print-format-settings.edit',$format->id) }}"
                                   class="btn btn-sm btn-light border">
                                    <i class="feather-edit text-warning"></i>
                                </a>

                                <form action="{{ route('print-format-settings.destroy',$format->id) }}"
                                      method="POST"
                                      style="display:inline-block;">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="btn btn-sm btn-light border"
                                            onclick="return confirm('Delete this print format?')">

                                        <i class="feather-trash-2 text-danger"></i>

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="6" class="text-center">
                            No Print Formats Found
                        </td>
                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection