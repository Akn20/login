@extends('layouts.admin')

@section('content')

<div class="nxl-content">

    <div class="page-header d-flex justify-content-between">
        <h5>Scan Types</h5>

        <a href="{{ route('admin.radiology.scan-types.create') }}" class="btn btn-primary">
            Add Scan Type
        </a>
    </div>

    <div class="card">
        <div class="card-body">

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($scanTypes as $key => $type)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $type->name }}</td>
                        <td>{{ $type->description }}</td>
                        <td>
                            <span class="badge {{ $type->status == 'Active' ? 'bg-success' : 'bg-danger' }}">
                                {{ $type->status }}
                            </span>
                        </td>

                        <td class="text-end">
                            <div class="hstack gap-2 justify-content-end">

                                {{-- ✏️ EDIT --}}
                                <a href="{{ route('admin.radiology.scan-types.edit', $type->id) }}"
                                    class="avatar-text avatar-md action-icon action-edit">
                                    <i class="feather-edit"></i>
                                </a>

                                {{-- 🗑️ DELETE --}}
                                <form action="{{ route('admin.radiology.scan-types.delete', $type->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this scan type?')">
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