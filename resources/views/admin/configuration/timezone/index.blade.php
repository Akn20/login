
@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    {{-- PAGE HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h4 class="mb-1">
                Timezone Settings
            </h4>

            <p class="text-muted mb-0">
                Manage system-wide timezone and date/time formats
            </p>

        </div>

        {{-- ADD BUTTON --}}
        <a href="{{ route('admin.configuration.timezones.create') }}"
           class="btn btn-primary">

            <i class="feather-plus"></i>

            Add Timezone

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
                                Timezone
                            </th>

                            <th width="15%">
                                Code
                            </th>

                            <th width="20%">
                                Date Format
                            </th>

                            <th width="15%">
                                Time Format
                            </th>

                            <th width="10%">
                                Default
                            </th>

                            <th width="15%">
                                Action
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($timezones as $timezone)

                            <tr>

                                {{-- TIMEZONE --}}
                                <td>

                                    <strong>

                                        {{ $timezone->timezone_name }}

                                    </strong>

                                </td>

                                {{-- CODE --}}
                                <td>

                                    <span class="badge bg-dark">

                                        {{ $timezone->timezone_code }}

                                    </span>

                                </td>

                                {{-- DATE FORMAT --}}
                                <td>

                                    <span class="badge bg-info">

                                        {{ $timezone->date_format }}

                                    </span>

                                </td>

                                {{-- TIME FORMAT --}}
                                <td>

                                    {{ $timezone->time_format }}

                                </td>

                                {{-- DEFAULT --}}
                                <td>

                                    @if($timezone->is_default)

                                        <span class="badge bg-primary">

                                            Default

                                        </span>

                                    @else

                                        <span class="badge bg-secondary">

                                            No

                                        </span>

                                    @endif

                                </td>

                                {{-- ACTION --}}
                                <td>

                                    {{-- EDIT --}}
                                    <a href="{{ route('admin.configuration.timezones.edit', $timezone->id) }}"
                                       class="text-warning me-2"
                                       title="Edit">

                                        <i class="feather-edit fs-5"></i>

                                    </a>

                                    {{-- DELETE --}}
                                    <form action="{{ route('admin.configuration.timezones.destroy', $timezone->id) }}"
                                          method="POST"
                                          class="d-inline">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="border-0 bg-transparent text-danger"
                                                title="Delete"
                                                onclick="return confirm('Are you sure you want to delete this timezone?')">

                                            <i class="feather-trash-2 fs-5"></i>

                                        </button>

                                    </form>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="6"
                                    class="text-center text-muted py-4">

                                    No Timezones Found

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            {{-- PAGINATION --}}
            <div class="mt-3">

                {{ $timezones->links() }}

            </div>

        </div>

    </div>

</div>

@endsection
