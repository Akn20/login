@extends('layouts.admin')

@section('content')

<div class="card">

    <div class="card-header d-flex justify-content-between">

        <h4>Tax Structures</h4>

        <a href="{{ route('admin.configuration.taxes.create') }}"
           class="btn btn-primary">

            Add Tax

        </a>

    </div>

    <div class="card-body">

        <table class="table table-bordered">

            <thead>

                <tr>

                    <th>Name</th>
                    <th>Percentage</th>
                    <th>Type</th>
                    <th>Calculation</th>
                    <th>Status</th>
                    <th>Action</th>

                </tr>

            </thead>

            <tbody>

                @foreach($taxes as $tax)

                <tr>

                    <td>{{ $tax->tax_name }}</td>

                    <td>{{ $tax->tax_percentage }}%</td>

                    <td>{{ $tax->tax_type }}</td>

                    <td>{{ $tax->calculation_type }}</td>

                    <td>

                        @if($tax->is_active)

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

                    {{-- EDIT --}}
                    <a href="{{ route('admin.configuration.taxes.edit', $tax->id) }}"
                    class="text-warning me-2"
                    title="Edit">

                        <i class="feather-edit fs-5"></i>

                    </a>

                    {{-- DELETE --}}
                    <form action="{{ route('admin.configuration.taxes.destroy', $tax->id) }}"
                        method="POST"
                        class="d-inline">

                        @csrf
                        @method('DELETE')

                        <button type="submit"
                                class="border-0 bg-transparent text-danger"
                                title="Delete"
                                onclick="return confirm('Are you sure you want to delete this tax?')">

                            <i class="feather-trash-2 fs-5"></i>

                        </button>

                    </form>

                </td>



                </tr>

                @endforeach

            </tbody>

        </table>

        {{ $taxes->links() }}

    </div>

</div>

@endsection
<style>
    .action-icon i:hover {
    transform: scale(1.1);
    transition: 0.2s;
}
</style>