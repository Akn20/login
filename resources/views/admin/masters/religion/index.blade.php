@extends('layouts.admin')

@section('content')
<<<<<<< HEAD

=======
>>>>>>> 5f0bf02b24999c4ebcafa7ae518a1d664ac37388
    <div class="nxl-content">

        <!-- Page Header -->
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Religion Master</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item">Masters</li>
                    <li class="breadcrumb-item">Religion</li>
                </ul>
            </div>

<<<<<<< HEAD
           <div class="page-header-right ms-auto d-flex gap-2">
    <a href="{{ route('admin.religion.trash') }}" class="btn btn-neutral">
        Deleted Records
    </a>

    <a href="{{ route('admin.religion.create') }}" class="btn btn-neutral">
        Add Religion
    </a>
</div>


=======
            <div class="page-header-right ms-auto d-flex gap-2">
                <a href="{{ route('admin.religion.trash') }}" class="btn btn-neutral">
                    Deleted Records
                </a>

                <a href="{{ route('admin.religion.create') }}" class="btn btn-neutral">
                    Add Religion
                </a>
            </div>
>>>>>>> 5f0bf02b24999c4ebcafa7ae518a1d664ac37388
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card stretch stretch-full">
                        <div class="card-body p-0">

                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Sl.No.</th>
                                            <th>Religion Name</th>
                                            <th>Status</th>
                                            <th class="text-end">Actions</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach($religions as $index => $religion)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $religion->religion_name }}</td>

                                                <td>
<<<<<<< HEAD
    @if($religion->status == 'Active')
        <span class="badge bg-soft-success text-success">Active</span>
    @else
        <span class="badge bg-soft-danger text-danger">Inactive</span>
    @endif
</td>


                                                <td class="text-end">
    <div class="hstack gap-2 justify-content-end">

        <a href="{{ route('admin.religion.edit', $religion->id) }}"
           class="avatar-text avatar-md action-icon action-edit">
            <i class="feather-edit"></i>
        </a>

        <form action="{{ route('admin.religion.delete', $religion->id) }}"
                                                            method="POST" class="d-inline"
                                                            onsubmit="return confirm('Are you sure you want to delete this religion?');">
                                                            @csrf
                                                            @method('DELETE')

                                                            <button type="submit"
                                                                class="avatar-text avatar-md action-icon action-delete"
                                                                title="Delete">
=======
                                                    @if($religion->status == 'Active')
                                                        <span class="badge bg-soft-success text-success">Active</span>
                                                    @else
                                                        <span class="badge bg-soft-danger text-danger">Inactive</span>
                                                    @endif
                                                </td>

                                                <td class="text-end">
                                                    <div class="hstack gap-2 justify-content-end">

                                                        {{-- Edit --}}
                                                        <a href="{{ route('admin.religion.edit', $religion->id) }}"
                                                            class="avatar-text avatar-md action-icon action-edit">
                                                            <i class="feather-edit"></i>
                                                        </a>

                                                        {{-- Delete (DELETE verb) --}}
                                                        <form action="{{ route('admin.religion.delete', $religion->id) }}"
                                                            method="POST"
                                                            onsubmit="return confirm('Are you sure you want to delete this religion?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="avatar-text avatar-md action-icon action-delete">
>>>>>>> 5f0bf02b24999c4ebcafa7ae518a1d664ac37388
                                                                <i class="feather-trash-2"></i>
                                                            </button>
                                                        </form>

<<<<<<< HEAD
    </div>
</td>

=======
                                                    </div>
                                                </td>
>>>>>>> 5f0bf02b24999c4ebcafa7ae518a1d664ac37388
                                            </tr>
                                        @endforeach
                                    </tbody>

                                </table>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
<<<<<<< HEAD

=======
>>>>>>> 5f0bf02b24999c4ebcafa7ae518a1d664ac37388
@endsection