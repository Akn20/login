@extends('layouts.admin')

@section('page-title', (isset($weekend) ? 'Edit' : 'Add') . ' Weekend | ' . config('app.name'))
@section('title', (isset($weekend) ? 'Edit' : 'Add') . ' Weekend')

@section('content')

    {{-- PAGE HEADER --}}
    <div class="page-header mb-4">
        <div class="d-flex justify-content-between align-items-center w-100">

            {{-- LEFT SIDE --}}
            <div class="page-header-title">
                <h5 class="m-b-10">
                    <i class="feather-calendar me-2"></i>{{ isset($weekend) ? 'Edit Weekend Configuration' : 'Add Weekend Configuration' }}
                </h5>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.weekends.index') }}">Weekend Configurations</a>
                    </li>
                    <li class="breadcrumb-item">{{ isset($weekend) ? 'Edit' : 'Create' }}</li>
                </ul>
            </div>

            {{-- RIGHT SIDE BUTTONS --}}
            <div class="d-flex gap-2">
                <a href="{{ route('admin.weekends.index') }}" class="btn btn-light">
                    <i class="feather-x me-2"></i> Cancel
                </a>

                <button type="submit" form="weekendForm" class="btn btn-primary">
                    <i class="feather-save me-2"></i> {{ isset($weekend) ? 'Update' : 'Save' }}
                </button>
            </div>

        </div>
    </div>

    <div class="card stretch stretch-full">
        <div class="card-body">

            {{-- FORM START --}}
            <form
                action="{{ isset($weekend)
                    ? route('admin.weekends.update', $weekend->id)
                    : route('admin.weekends.store') }}"
                method="POST"
                id="weekendForm"
            >
                @csrf
                @if(isset($weekend))
                    @method('PUT')
                @endif

                <div class="row">

                    {{-- LEFT COLUMN --}}
                    <div class="col-lg-6">

                        {{-- Configuration Name --}}
                        <div class="mb-3">
                            <label class="form-label">Weekend Name<span class="text-danger">*</span></label>
                            <input
                                type="text"
                                name="name"
                                value="{{ old('name', $weekend->name ?? '') }}"
                                class="form-control @error('name') is-invalid @enderror"
                                placeholder="e.g., Standard Nursing Shift Offs"
                            >
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Weekend Days --}}
                   <div class="mb-3">
    <label class="form-label">Weekend Days<span class="text-danger">*</span></label>
    @php
        $selectedDays = old(
            'days',
            isset($weekend) && $weekend->days
                ? (is_array($weekend->days) ? $weekend->days : (json_decode($weekend->days, true) ?? []))
                : []
        );
    @endphp
    <select
        id="weekend-days-select"
        name="days[]"
        class="form-select @error('days') is-invalid @enderror"
        multiple
        autocomplete="off"
    >
        @foreach ($days as $day)
            <option
                value="{{ $day }}"
                {{ collect($selectedDays)->contains($day) ? 'selected' : '' }}
            >
                {{ $day }}
            </option>
        @endforeach
    </select>

    @error('days')
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
    @error('days.*')
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>


                    </div>

                    {{-- RIGHT COLUMN --}}
                    <div class="col-lg-6">

                        {{-- Status --}}
                        <div class="mb-3">
                            <label class="form-label">Status<span class="text-danger">*</span></label>
                            @php
                                $statusValue = old('status', $weekend->status ?? 'inactive');
                            @endphp
                            <select
                                name="status"
                                class="form-select @error('status') is-invalid @enderror"
                            >
                                <option value="active"   {{ $statusValue === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ $statusValue === 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            
                        </div>

                    </div>

                </div>

            </form>
            {{-- FORM END --}}

        </div>
    </div>

@endsection
