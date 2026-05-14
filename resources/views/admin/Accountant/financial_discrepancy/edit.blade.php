@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    <div class="card">

    <div class="page-header mb-4">

        <div class="page-header-left">
            <h5 class="m-b-0">
                Edit Financial Discrepancy
            </h5>
        </div>

        <div class="page-header-right ms-auto">

            <a href="{{ route('admin.financial-discrepancy.index') }}"
               class="btn btn-light">

                Back

            </a>

        </div>

    </div>
    
     <div class="card">

        <div class="card-body">

            <form action="{{ route('admin.financial-discrepancy.update', $discrepancy->id) }}"
                  method="POST">

                @method('PUT')
                @csrf

                <div class="mb-3">

                        <label>Reconciliation</label>

                        <select name="financial_reconciliation_id"
                                class="form-control"
                                required>


                          @foreach($reconciliations as $item)

                    <option value="{{ $item->id }}"

                        {{ $discrepancy->financial_reconciliation_id == $item->id
                            ? 'selected'
                            : '' }}>

                        {{ $item->reconciliation_date }}
                        -
                        ₹ {{ number_format(
                            $item->total_cash +
                            $item->total_digital,
                            2
                        ) }}

                    </option>

                @endforeach

                                        </select>

                                    </div>

                                <div class="mb-3">

                    <label>Issue Type</label>

                    <input type="text"
                           name="issue_type"
                           class="form-control"
                           value="{{ $discrepancy->issue_type }}"
                           required>

                </div>

                <div class="mb-3">

                    <label>Expected Amount</label>

                    <input type="number"
                           step="0.01"
                           name="expected_amount"
                           class="form-control"
                           value="{{ $discrepancy->expected_amount }}"
                           required>

                </div>

                <div class="mb-3">

                    <label>Actual Amount</label>

                    <input type="number"
                           step="0.01"
                           name="actual_amount"
                           class="form-control"
                           value="{{ $discrepancy->actual_amount }}"
                           required>

                </div>

                <div class="mb-3">

                    <label>Status</label>

                    <select name="status"
                            class="form-control"
                            required>

                        <option value="Open"
                            {{ $discrepancy->status == 'Open' ? 'selected' : '' }}>
                            Open
                        </option>

                        <option value="Resolved"
                            {{ $discrepancy->status == 'Resolved' ? 'selected' : '' }}>
                            Resolved
                        </option>

                    </select>

                </div>



                <div class="mb-3">

                    <label>Remarks</label>

                    <textarea name="remarks"
                              class="form-control">{{ $discrepancy->remarks }}</textarea>

                </div>

                <button type="submit"
                        class="btn btn-success">

                    Save Discrepancy

                </button>

            </form>

        </div>

    </div>


@endsection