
@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    {{-- PAGE HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h4 class="mb-1">
                Currency Settings
            </h4>

            <p class="text-muted mb-0">
                Manage system-wide currencies
            </p>

        </div>

        {{-- ADD BUTTON --}}
        <a href="{{ route('admin.configuration.currencies.create') }}"
           class="btn btn-primary">

            <i class="feather-plus"></i>

            Add Currency

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

                            <th width="20%">
                                Currency Name
                            </th>

                            <th width="15%">
                                Code
                            </th>

                            <th width="15%">
                                Symbol
                            </th>

                            <th width="15%">
                                Decimal Places
                            </th>

                            <th width="15%">
                                Default
                            </th>

                            <th width="10%">
                                Status
                            </th>

                            <th width="10%">
                                Action
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($currencies as $currency)

                            <tr>

                                {{-- NAME --}}
                                <td>

                                    {{ $currency->currency_name }}

                                </td>

                                {{-- CODE --}}
                                <td>

                                    <span class="badge bg-dark">

                                        {{ $currency->currency_code }}

                                    </span>

                                </td>

                                {{-- SYMBOL --}}
                                <td>

                                    <strong style="font-size: 18px;">

                                        {{ $currency->currency_symbol }}

                                    </strong>

                                </td>

                                {{-- DECIMAL --}}
                                <td>

                                    {{ $currency->decimal_places }}

                                </td>

                                {{-- DEFAULT --}}
                                <td>

                                    @if($currency->is_default)

                                        <span class="badge bg-primary">

                                            Default Currency

                                        </span>

                                    @else

                                        <span class="badge bg-secondary">

                                            No

                                        </span>

                                    @endif

                                </td>

                                {{-- STATUS --}}
                                <td>

                                    <span class="badge bg-success">

                                        Active

                                    </span>

                                </td>

                                {{-- ACTION --}}
                                <td>

                                    {{-- EDIT --}}
                                    <a href="{{ route('admin.configuration.currencies.edit', $currency->id) }}"
                                       class="text-warning me-2"
                                       title="Edit">

                                        <i class="feather-edit fs-5"></i>

                                    </a>

                                    {{-- DELETE --}}
                                    <form action="{{ route('admin.configuration.currencies.destroy', $currency->id) }}"
                                          method="POST"
                                          class="d-inline">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="border-0 bg-transparent text-danger"
                                                title="Delete"
                                                onclick="return confirm('Are you sure you want to delete this currency?')">

                                            <i class="feather-trash-2 fs-5"></i>

                                        </button>

                                    </form>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="7"
                                    class="text-center text-muted py-4">

                                    No Currency Found

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            {{-- PAGINATION --}}
            <div class="mt-3">

                {{ $currencies->links() }}

            </div>

        </div>

    </div>

</div>

@endsection

