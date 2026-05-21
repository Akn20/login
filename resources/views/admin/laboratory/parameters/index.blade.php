@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    {{-- PAGE HEADER --}}
    <div class="page-header mb-4">

        <div class="page-header-left">

            <h5 class="m-b-0">
                Laboratory Test Parameters
            </h5>

        </div>

        <div class="page-header-right ms-auto">

            <a href="{{ route('admin.laboratory.parameters.create') }}"
               class="btn btn-primary">

                <i class="feather-plus me-2"></i>

                Add Parameter

            </a>

        </div>

    </div>

    {{-- CARD --}}
    <div class="card">

        <div class="card-body table-responsive">

            <table class="table table-bordered align-middle">

                <thead class="text-center">

                    <tr>

                        <th width="80">#</th>

                        <th>Parameter Name</th>

                        <th>Unit</th>

                        <th>Reference Range</th>

                        <th width="180">Action</th>

                    </tr>

                </thead>

                <tbody class="text-center">

                    @forelse($parameters as $key => $param)

                        <tr>

                            <td>
                                {{ $key + 1 }}
                            </td>

                            <td>
                                {{ $param->name }}
                            </td>

                            <td>
                                {{ $param->unit ?? '-' }}
                            </td>

                            <td>

                                {{ $param->min_value ?? '0' }}

                                -

                                {{ $param->max_value ?? '0' }}

                            </td>

                            <td>

                                <div class="d-flex justify-content-center gap-2">

                                    {{-- EDIT --}}
                                    <a href="{{ route('admin.laboratory.parameters.edit', $param->id) }}"
                                       class="btn btn-outline-primary btn-icon rounded-circle"
                                       title="Edit">

                                        <i class="feather-edit"></i>

                                    </a>

                                    {{-- DELETE --}}
                                    <form action="{{ route('admin.laboratory.parameters.destroy', $param->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Delete this parameter?')">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="btn btn-outline-danger btn-icon rounded-circle"
                                                title="Delete">

                                            <i class="feather-trash-2"></i>

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="5" class="text-center">

                                No parameters found

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection