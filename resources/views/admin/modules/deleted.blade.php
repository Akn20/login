@extends('layouts.admin')

@section('content')

    <div class="container">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0">Deleted Modules</h4>

            <a href="{{ route('modules.index') }}" class="btn btn-sm btn-outline-primary">
                <i class="feather feather-arrow-left"></i> Back
            </a>
        </div>


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

                            @if($modules->count() > 0)

                                @foreach($modules as $index => $module)
                                    <tr>



                                        <!-- Serial Number -->
                                        <td>{{ $index + 1 }}</td>

                                        <!-- Module Label -->
                                        <td>{{ $module->module_label }}</td>

                                        <!-- Display Name -->
                                        <td>{{ $module->module_display_name }}</td>

                                        <!-- Parent -->
                                        <td>{{ $module->parent_module ?? '-' }}</td>

                                        <!-- File Path -->
                                        <td>{{ $module->file_url }}</td>

                                        <!-- Access For -->
                                        <td>{{ ucfirst($module->access_for) }}</td>

                                        <!-- Page Name -->
                                        <td>{{ $module->page_name }}</td>

                                        <!-- Type -->
                                        <td>{{ ucfirst($module->type) }}</td>

                                        <!-- Actions -->

                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-2">

                                                <!-- Restore -->
                                                <a href="{{ route('modules.restore', $module->id) }}"
                                                    class="avatar-text avatar-md text-success" data-bs-toggle="tooltip"
                                                    title="Restore">
                                                    <i class="feather feather-rotate-ccw"></i>
                                                </a>

                                                <!-- Permanent Delete -->
                                                <form action="{{ route('modules.forceDelete', $module->id) }}" method="POST"
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