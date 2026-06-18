@extends('layouts.admin')

@section('content')

<div class="main-content">

    <div class="page-header">
        <h4>Local Tax Settings</h4>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">

        <div class="card-header d-flex justify-content-between">

            <h5>Local Tax Settings List</h5>

            <a href="{{ route('local-tax-settings.create') }}"
               class="btn btn-primary">

                <i class="feather-plus"></i>
                Add Tax Setting

            </a>

        </div>

        <div class="card-body">

            <table class="table table-bordered table-striped">

                <thead>

                    <tr>
                        <th>ID</th>
                        <th>Tax Name</th>
                        <th>Tax %</th>
                        <th>Tax Type</th>
                        <th>Applicable On</th>
                        <th>Status</th>
                        <th width="150">Actions</th>
                    </tr>

                </thead>

                <tbody>

                    @forelse($taxes as $tax)

                    <tr>

                        <td>{{ $tax->id }}</td>

                        <td>{{ $tax->tax_name }}</td>

                        <td>{{ $tax->tax_percentage }}%</td>

                        <td>{{ $tax->tax_type }}</td>

                        <td>{{ $tax->applicable_on }}</td>

                        <td>

                            @if($tax->status == 'Active')

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

                                <a href="{{ route('local-tax-settings.show',$tax->id) }}"
                                   class="btn btn-sm btn-light border"
                                   title="View">

                                    <i class="feather-eye text-info"></i>

                                </a>

                                <a href="{{ route('local-tax-settings.edit',$tax->id) }}"
                                   class="btn btn-sm btn-light border"
                                   title="Edit">

                                    <i class="feather-edit text-warning"></i>

                                </a>

                                <form action="{{ route('local-tax-settings.destroy',$tax->id) }}"
                                      method="POST"
                                      style="display:inline-block;">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="btn btn-sm btn-light border"
                                            title="Delete"
                                            onclick="return confirm('Delete this tax setting?')">

                                        <i class="feather-trash-2 text-danger"></i>

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="7" class="text-center">

                            No Tax Settings Found

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection