@extends('layouts.admin')

@section('content')

<div class="main-content">

    <div class="page-header">
        <h4>Prescription Format Settings</h4>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">

        <div class="card-header d-flex justify-content-between align-items-center">

            <h5 class="mb-0">Prescription Format List</h5>

            <a href="{{ route('prescription-format-settings.create') }}"
               class="btn btn-primary">

                <i class="feather-plus"></i>
                Add Format

            </a>

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-striped">

                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Header Text</th>
                            <th>Footer Text</th>
                            <th>Paper Size</th>
                            <th>Orientation</th>
                            <th>Margins</th>
                            <th>Status</th>
                            <th width="180">Actions</th>
                        </tr>
                    </thead>

                    <tbody>

                    @forelse($formats as $format)

                        <tr>

                            <td>{{ $format->id }}</td>

                            <td>
                                {{ Str::limit($format->header_text, 50) }}
                            </td>

                            <td>
                                {{ Str::limit($format->footer_text, 50) }}
                            </td>

                            <td>{{ $format->paper_size }}</td>

                            <td>{{ $format->orientation }}</td>

                            <td>{{ $format->margins }} mm</td>

                            <td>
                                @if($format->status == 'Active')
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

                                <div class="d-flex align-items-center">

                                    <!-- View -->
                                    <a href="{{ route('prescription-format-settings.show', $format->id) }}"
                                       class="btn btn-sm btn-light border me-2">

                                        <i class="feather-eye text-info"></i>

                                    </a>

                                    <!-- Edit -->
                                    <a href="{{ route('prescription-format-settings.edit', $format->id) }}"
                                       class="btn btn-sm btn-light border me-2">

                                        <i class="feather-edit text-warning"></i>

                                    </a>

                                    <!-- Delete -->
                                    <form action="{{ route('prescription-format-settings.destroy', $format->id) }}"
                                          method="POST"
                                          style="display:inline-block;">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="btn btn-sm btn-light border"
                                                onclick="return confirm('Delete this prescription format?')">

                                            <i class="feather-trash-2 text-danger"></i>

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="8" class="text-center">
                                No Prescription Formats Found
                            </td>
                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection