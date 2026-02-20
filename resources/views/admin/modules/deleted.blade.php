@extends('layouts.admin')

@section('page-title', 'Deleted Modules | ' . config('app.name'))

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0">Deleted Modules</h4>

            <a href="{{ route('admin.modules.index') }}" class="btn btn-sm btn-outline-primary">
                <i class="feather feather-arrow-left"></i> Back
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success mb-3">
                {{ session('success') }}
            </div>
        @endif

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover" id="proposalList">
                        <thead>
                            <tr>
                                <th>SL.NO</th>
                                <th>Module Label</th>
                                <th>Display Name</th>
                                <th>Parent</th>
                                <th>File Path</th>
                                <th>Access For</th>
                                <th>Page Name</th>
                                <th>Type</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($modules->count() > 0)
                                @foreach ($modules as $index => $module)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $module->module_label }}</td>
                                        <td>{{ $module->module_display_name }}</td>
                                        <td>{{ $module->parent_module ?? '-' }}</td>
                                        <td>{{ $module->file_url }}</td>
                                        <td>{{ ucfirst($module->access_for) }}</td>
                                        <td>{{ $module->page_name }}</td>
                                        <td>{{ ucfirst($module->type) }}</td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-2">
                                                {{-- Restore --}}
                                                <form action="{{ route('admin.modules.restore', $module->id) }}" method="POST"
                                                    class="m-0 d-inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit"
                                                        class="avatar-text avatar-md border-0 bg-transparent text-success"
                                                        data-bs-toggle="tooltip" title="Restore">
                                                        <i class="feather feather-rotate-ccw"></i>
                                                    </button>
                                                </form>

                                                {{-- Force delete --}}
                                                <form action="{{ route('admin.modules.forceDelete', $module->id) }}" method="POST"
                                                    onsubmit="return confirm('Permanently delete this module?')" class="m-0">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="avatar-text avatar-md border-0 bg-transparent text-danger"
                                                        data-bs-toggle="tooltip" title="Delete Permanently">
                                                        <i class="feather feather-trash-2"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="10" class="text-center">No Modules Found</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection