@extends('layouts.admin')

@section('content')

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2 class="fw-bold">
            Case Sheet Management
        </h2>

        <a href="{{ route('admin.casesheets.create') }}"
           class="btn btn-primary">

            <i class="feather-plus"></i>

            Create Case Sheet

        </a>

    </div>

    <div class="card shadow-sm border-0">

        <div class="card-body">

            <table class="table table-hover align-middle">

                <thead style="background-color: white;">

                    <tr>

                        <th>Patient ID</th>

                        <th>Doctor ID</th>

                        <th>Visit Type</th>

                        <th>Status</th>

                        <th width="180">Actions</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($caseSheets as $case)

                    <tr>

                       <td>

                    {{ $case->patient->patient_code ?? '' }}

    -

                         {{ $case->patient->first_name ?? '' }}
                         {{ $case->patient->last_name ?? '' }}

</td>

<td>

    Dr. {{ $case->doctor->name ?? '' }}

</td>

                        <td>{{ $case->visit_type }}</td>

                        <td>

                            <span class="badge bg-success">

                                {{ $case->status }}

                            </span>

                        </td>

                        <td>

                            <div class="d-flex gap-2">

                                {{-- View --}}
                                <a href="{{ route('admin.casesheets.show', $case->id) }}"
                                   class="btn btn-light btn-sm border rounded-circle d-flex align-items-center justify-content-center"
                                   style="width:35px; height:35px;">

                                    <i class="feather-eye"></i>

                                </a>

                                {{-- Edit --}}
                                <a href="{{ route('admin.casesheets.edit', $case->id) }}"
                                   class="btn btn-light btn-sm border rounded-circle d-flex align-items-center justify-content-center"
                                   style="width:35px; height:35px;">

                                    <i class="feather-edit-2"></i>

                                </a>

                                {{-- Delete --}}
                                <form action="{{ route('admin.casesheets.destroy', $case->id) }}"
                                      method="POST">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="btn btn-light btn-sm border rounded-circle d-flex align-items-center justify-content-center"
                                            style="width:35px; height:35px;">

                                        <i class="feather-trash-2"></i>

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="5"
                            class="text-center text-muted py-4">

                            No Case Sheets Found

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection