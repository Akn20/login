@extends('layouts.admin')

@section('content')

<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h3 class="fw-bold">
                Deleted Referrals
            </h3>

        </div>

        <a href="{{ route('doctor.referrals.index') }}"
           class="btn btn-secondary">

            Back

        </a>

    </div>

    <div class="card shadow-sm border-0">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered align-middle">

                    <thead class="table-light">

                        <tr>

                            <th>#</th>

                            <th>Patient</th>

                            <th>Status</th>

                            <th>Deleted At</th>

                            <th width="220">
                                Actions
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($referrals as $key => $referral)

                            <tr>

                                <td>
                                    {{ $key + 1 }}
                                </td>

                                <td>

                                    {{ $referral->patient->first_name ?? '' }}
                                    {{ $referral->patient->last_name ?? '' }}

                                </td>

                                <td>

                                    {{ $referral->status }}

                                </td>

                                <td>

                                    {{ $referral->deleted_at }}

                                </td>

                                <td>

                                    <div class="d-flex gap-2">

                                        <!-- Restore -->
                                        <form action="{{ route('doctor.referrals.restore', $referral->id) }}"
                                              method="POST">

                                            @csrf

                                            <button class="btn btn-success btn-sm">

                                                Restore

                                            </button>

                                        </form>

                                        <!-- Permanent Delete -->
                                        <form action="{{ route('doctor.referrals.forceDelete', $referral->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Permanent delete?')">

                                            @csrf
                                            @method('DELETE')

                                            <button class="btn btn-danger btn-sm">

                                                Delete Permanently

                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="5"
                                    class="text-center">

                                    No Deleted Records

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection