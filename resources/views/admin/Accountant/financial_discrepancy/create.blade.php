@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    <div class="card">

        <div class="card-header">
            <h5>Create Financial Discrepancy</h5>
        </div>

        <div class="card-body">

            <form action="{{ route('admin.financial-discrepancy.store') }}"
                  method="POST">

                @csrf

                <div class="mb-3">

                    <label>Reconciliation</label>

                    <select name="financial_reconciliation_id"
                            class="form-control"
                            required>

                        <option value="">
                            Select Reconciliation
                        </option>

                        @foreach($reconciliations as $reconciliation)

                            <option value="{{ $item->id }}">

    REC-{{ date('dm', strtotime($item->reconciliation_date)) }}
    -{{ strtoupper(substr($item->id, 0, 4)) }}

    |

    ₹ {{ number_format($item->total_cash + $item->total_digital, 2) }}

    |

    {{ $item->status }}

</option>

                        @endforeach

                    </select>

                </div>

                <div class="mb-3">

                    <label>Issue Type</label>

                    <input type="text"
                           name="issue_type"
                           class="form-control"
                           required>

                </div>

                <div class="mb-3">

                    <label>Expected Amount</label>

                    <input type="number"
                           step="0.01"
                           name="expected_amount"
                           class="form-control"
                           required>

                </div>

                <div class="mb-3">

                    <label>Actual Amount</label>

                    <input type="number"
                           step="0.01"
                           name="actual_amount"
                           class="form-control"
                           required>

                </div>

                <div class="mb-3">

                    <label>Remarks</label>

                    <textarea name="remarks"
                              class="form-control"></textarea>

                </div>

                <button type="submit"
                        class="btn btn-success">

                    Save Discrepancy

                </button>

            </form>

        </div>

    </div>

</div>

@endsection