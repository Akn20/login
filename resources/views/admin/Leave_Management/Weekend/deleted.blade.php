@extends('layouts.admin')

@section('page-title', 'Deleted Weekend Configurations | ' . config('app.name'))
@section('title', 'Weekend Configurations')

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="page-header mb-4 d-flex align-items-center justify-content-between">
        <div class="page-header-title">
            <h5 class="m-b-10 mb-1">
                <i class="feather-trash-2 me-2"></i>Deleted Weekend Configurations
            </h5>
            <ul class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.weekends.index') }}">Weekend Configurations</a>
                </li>
                <li class="breadcrumb-item">Deleted</li>
            </ul>
        </div>

        <div>
            <a href="{{ route('admin.weekends.index') }}" class="btn btn-light">
                <i class="feather-arrow-left me-1"></i> Back to List
            </a>
        </div>
    </div>

    <div class="card stretch stretch-full">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Configuration Name</th>
                            <th>Selected Days</th>
                            <th>Deleted At</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($weekends->count())
                            @foreach ($weekends as $index => $weekend)
                                <tr>
                                    <td>{{ $weekends->firstItem() ? $weekends->firstItem() + $index : $index + 1 }}</td>

                                    <td>{{ $weekend->name }}</td>

                                    <td>
                                        @php
                                            $days = is_array($weekend->days)
                                                ? $weekend->days
                                                : (json_decode($weekend->days, true) ?? []);
                                        @endphp
                                        {{ $days ? implode(', ', $days) : '-' }}
                                    </td>

                                    <td>{{ $weekend->deleted_at?->format('d-m-Y H:i') }}</td>

                                    <td class="text-end">
                                        <div class="d-flex justify-content-end gap-2 align-items-center">
                                            {{-- Restore --}}
                                            <form
                                                action="{{ route('admin.weekends.restore', $weekend->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Restore this configuration?')"
                                            >
                                                @csrf
                                                <button
                                                    type="submit"
                                                    class="btn btn-outline-success btn-icon rounded-circle"
                                                    title="Restore"
                                                >
                                                    <i class="feather-rotate-ccw"></i>
                                                </button>
                                            </form>

                                            {{-- Force delete --}}
                                            <form
                                                action="{{ route('admin.weekends.forceDelete', $weekend->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Permanently delete this configuration? This cannot be undone.')"
                                            >
                                                @csrf
                                                @method('DELETE')
                                                <button
                                                    type="submit"
                                                    class="btn btn-outline-danger btn-icon rounded-circle"
                                                    title="Delete Permanently"
                                                >
                                                    <i class="feather-x-circle"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5" class="text-center">No deleted weekend configurations found.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            @if ($weekends->hasPages())
                <div class="mt-3 px-3 pb-3">
                    {{ $weekends->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
