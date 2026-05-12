@extends('layouts.admin')

@section('content')

    <div class="container">

        <h4>Test Parameters</h4>

        <a href="{{ route('admin.laboratory.parameters.create') }}" class="btn btn-primary mb-3">
            Add Parameter
        </a>

        <table class="table table-bordered">
            <thead align="center">
                <tr>
                    <th>Name</th>
                    <th>Unit</th>
                    <th>Range</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody align="center">
                @foreach($parameters as $param)
                    <tr>
                        <td>{{ $param->name }}</td>
                        <td>{{ $param->unit }}</td>
                        <td>{{ $param->min_value }} - {{ $param->max_value }}</td>



                        <td>
                            <div class="hstack gap-2 justify-content-center">
                                <a href="{{ route('admin.laboratory.parameters.edit', $param->id) }}"
                                    class="avatar-text avatar-md" data-bs-toggle="tooltip" title="Edit">
                                    <i class="feather feather-edit"></i>
                                </a>

                                <form action="{{ route('admin.laboratory.parameters.destroy', $param->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="avatar-text avatar-md d-flex align-items-center justify-content-center"
                                        data-bs-toggle="tooltip" title="Delete">
                                        <i class="feather feather-trash-2"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>

@endsection