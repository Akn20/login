@extends('layouts.admin')

@section('content')

<div class="main-content">

    <div class="page-header">
        <h4>Invoice Templates</h4>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">

        <div class="card-header d-flex justify-content-between">

            <h5>Invoice Template List</h5>

            <a href="{{ route('invoice-templates.create') }}"
               class="btn btn-primary">

                <i class="feather-plus"></i>
                Add Template

            </a>

        </div>

        <div class="card-body">

            <table class="table table-bordered table-striped">

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Template Name</th>
                        <th>Prefix</th>
                        <th>Starting Number</th>
                        <th>Status</th>
                        <th width="150">Actions</th>
                    </tr>
                </thead>

                <tbody>

                @forelse($templates as $template)

                    <tr>

                        <td>{{ $template->id }}</td>
                        <td>{{ $template->template_name }}</td>
                        <td>{{ $template->invoice_prefix }}</td>
                        <td>{{ $template->starting_number }}</td>

                        <td>
                            @if($template->status == 'Active')
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-danger">Inactive</span>
                            @endif
                        </td>

                        <td>

                            <div class="d-flex align-items-center gap-2">

                                <a href="{{ route('invoice-templates.show',$template->id) }}"
                                   class="btn btn-sm btn-light border">

                                    <i class="feather-eye text-info"></i>

                                </a>

                                <a href="{{ route('invoice-templates.edit',$template->id) }}"
                                   class="btn btn-sm btn-light border">

                                    <i class="feather-edit text-warning"></i>

                                </a>

                                <form action="{{ route('invoice-templates.destroy',$template->id) }}"
                                      method="POST"
                                      style="display:inline-block;">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="btn btn-sm btn-light border"
                                            onclick="return confirm('Delete this invoice template?')">

                                        <i class="feather-trash-2 text-danger"></i>

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="6" class="text-center">
                            No Invoice Templates Found
                        </td>
                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection