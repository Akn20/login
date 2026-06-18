
@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    {{-- PAGE HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h4 class="mb-1">
                Rounding Rules
            </h4>

            <p class="text-muted mb-0">
                Manage billing and financial rounding precision
            </p>

        </div>

        {{-- ADD BUTTON --}}
        <a href="{{ route('admin.configuration.rounding-rules.create') }}"
           class="btn btn-primary">

            <i class="feather-plus"></i>

            Add Rule

        </a>

    </div>

    {{-- SUCCESS MESSAGE --}}
    @if(session('success'))

        <div class="alert alert-success">

            {{ session('success') }}

        </div>

    @endif

    {{-- CARD --}}
    <div class="card border-0 shadow-sm">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table align-middle table-bordered">

                    <thead class="table-light">

                        <tr>

                            <th width="25%">
                                Module
                            </th>

                            <th width="25%">
                                Rounding Type
                            </th>

                            <th width="15%">
                                Decimal Places
                            </th>

                            <th width="15%">
                                Status
                            </th>

                            <th width="20%">
                                Action
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($rules as $rule)

                            <tr>

                                {{-- MODULE --}}
                                <td>

                                    <strong>

                                        {{ $rule->module_name }}

                                    </strong>

                                </td>

                                {{-- ROUNDING TYPE --}}
                                <td>

                                    <span class="badge bg-info">

                                        {{ $rule->rounding_type }}

                                    </span>

                                </td>

                                {{-- DECIMAL --}}
                                <td>

                                    {{ $rule->decimal_places }}

                                </td>

                                {{-- STATUS --}}
                                <td>

                                    @if($rule->is_active)

                                        <span class="badge bg-success">

                                            Active

                                        </span>

                                    @else

                                        <span class="badge bg-danger">

                                            Inactive

                                        </span>

                                    @endif

                                </td>

                                {{-- ACTION --}}
                                <td>

                                    {{-- EDIT --}}
                                    <a href="{{ route('admin.configuration.rounding-rules.edit', $rule->id) }}"
                                       class="text-warning me-2"
                                       title="Edit">

                                        <i class="feather-edit fs-5"></i>

                                    </a>

                                    {{-- DELETE --}}
                                    <form action="{{ route('admin.configuration.rounding-rules.destroy', $rule->id) }}"
                                          method="POST"
                                          class="d-inline">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="border-0 bg-transparent text-danger"
                                                title="Delete"
                                                onclick="return confirm('Are you sure you want to delete this rule?')">

                                            <i class="feather-trash-2 fs-5"></i>

                                        </button>

                                    </form>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="5"
                                    class="text-center text-muted py-4">

                                    No Rounding Rules Found

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            {{-- PAGINATION --}}
            <div class="mt-3">

                {{ $rules->links() }}

            </div>

        </div>

    </div>

</div>

@endsection

