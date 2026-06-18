
@extends('layouts.admin')

@section('content')

<div class="container">

    <div class="card shadow-sm">

        <div class="card-header">

            <h4 class="mb-0">
                Deleted Follow-ups
            </h4>

            <a href="{{ route('doctor.followups.index') }}"
               class="btn btn-sm btn-outline-primary">
                <i class="feather feather-arrow-left"></i> Back
            </a>

        </div>

        <div class="card-body">

            <table class="table table-bordered">

                <thead>

                    <tr>

                        <th>#</th>

                        <th>Patient</th>

                        <th>Doctor</th>

                        <th>Date</th>

                        <th>Status</th>

                        <th>Actions</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($followUps as $followup)

                        <tr>

                            <td>
                                {{ $loop->iteration }}
                            </td>

                            <td>

                                {{ optional($followup->patient)->first_name }}
                                {{ optional($followup->patient)->last_name }}

                            </td>

                            <td>

                                {{ optional($followup->doctor)->name }}

                            </td>

                            <td>

                                {{ $followup->follow_up_date }}

                            </td>

                            <td>

                                {{ $followup->status }}

                            </td>

                           <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">

                                            {{-- Restore --}}
                                            <form action="{{ route('doctor.followups.restore', $followup->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')

                                                <button type="submit"
                                                    class="avatar-text avatar-md border-0 bg-transparent text-success">
                                                    <i class="feather feather-rotate-ccw"></i>
                                                </button>
                                            </form>

                                            {{-- Permanent Delete --}}
                                            <form action="{{ route('doctor.followups.force-delete', $followup->id) }}" method="POST"
                                                onsubmit="return confirm('Permanently delete this follow-up?')">

                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                    class="avatar-text avatar-md border-0 bg-transparent text-danger">
                                                    <i class="feather feather-trash-2"></i>
                                                </button>
                                            </form>

                                        </div>
                                    </td>
                        </tr>

                    @empty

                        <tr>

                            <td colspan="5"
                                class="text-center">

                                No deleted follow-ups found

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection

