@extends('layouts.admin')

@section('page-title', 'Modules | ' . config('app.name'))

@section('content')

    <div class="main-content">

        {{-- ================= SUCCESS MESSAGE ================= --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- ================= PAGE HEADER ================= --}}
        <div class="page-header mb-4">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Modules</h5>
                </div>
            </div>

            <div class="page-header-right ms-auto d-flex align-items-center gap-2">
                <a href="{{ route('admin.modules.create') }}" class="btn btn-primary">
                    <i class="feather-plus me-2"></i>
                    Add Module
                </a>
            </div>
        </div>

        {{-- ================= TABLE CARD ================= --}}
        <div class="card stretch stretch-full">
            <div class="card-body p-0">
                <div class="table-responsive">

                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th></th>
                                <th>S.N</th>
                                <th>Module Label</th>
                                <th>Display Name</th>
                                <th>Parent</th>
                                <th>File Path</th>
                                <th>Access For</th>
                                <th>Page Name</th>
                                <th>Type</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>

                        <tbody>

                            @if($modules->count() > 0)

                                @foreach($modules as $index => $module)
                                    <tr>

                                        <td>
                                            <div class="custom-control custom-checkbox ms-1">
                                                <input type="checkbox" class="custom-control-input" id="check{{ $module->id }}">
                                                <label class="custom-control-label" for="check{{ $module->id }}"></label>
                                            </div>
                                        </td>

                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $module->module_label }}</td>
                                        <td>{{ $module->module_display_name }}</td>
                                        <td>{{ $module->parent_module ?? '-' }}</td>
                                        <td>{{ $module->file_url }}</td>
                                        <td>{{ ucfirst($module->access_for) }}</td>
                                        <td>{{ $module->page_name }}</td>
                                        <td>{{ ucfirst($module->type) }}</td>


                                        <td class="text-end">
                                            <div class="hstack gap-2 justify-content-end">

                                                <!-- View Icon -->
                                                <a href="{{ route('admin.modules.index', $module->id) }}"
                                                    class="avatar-text avatar-md" data-bs-toggle="tooltip" title="View">
                                                    <i class="feather feather-eye"></i>
                                                </a>

                                                <!-- Delete Icon -->
                                                <form action="{{ route('admin.modules.destroy', $module->id) }}" method="POST"
                                                    onsubmit="return confirm('Are you sure?')">

                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="avatar-text avatar-md border-0 bg-transparent"
                                                        data-bs-toggle="tooltip" title="Delete">
                                                        <i class="feather feather-trash-2"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>


                                    </tr>
                                @endforeach

                            @else

                                <tr>
                                    <td colspan="10" class="text-center py-4">
                                        No Modules Found
                                    </td>
                                </tr>

                            @endif

                        </tbody>

                    </table>

                </div>
            </div>
        </div>

    </div>

@endsection