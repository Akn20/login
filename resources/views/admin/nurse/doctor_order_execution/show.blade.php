@extends('layouts.admin')

@section('content')

<div class="container-fluid"><div class="row mb-3">
    <div class="col-md-12 d-flex justify-content-between align-items-center">

        <h3>Doctor Order Details</h3>

        <a href="{{ route('admin.doctor-order-execution.index') }}"
           class="btn btn-secondary btn-sm">
            <i class="feather-arrow-left"></i>
            Back
        </a>

    </div>
</div>

<div class="card">

    <div class="card-body">

        <table class="table table-bordered">

         @if($type != 'Medication')
<tr>
    <th width="250">Patient Name</th>
    <td>
        {{ $order->patient->first_name ?? '' }}
        {{ $order->patient->last_name ?? '' }}
    </td>
</tr>
@endif

            <tr>
                <th>Order Type</th>
                <td>{{ $type }}</td>
            </tr>

            {{-- LAB DETAILS --}}
            @if($type == 'Lab')

            <tr>
                <th>Test Name</th>
                <td>{{ $order->test_name }}</td>
            </tr>

            <tr>
                <th>Priority</th>
                <td>{{ $order->priority }}</td>
            </tr>

            <tr>
                <th>Status</th>
                <td>{{ $order->status }}</td>
            </tr>

            @endif


            {{-- RADIOLOGY DETAILS --}}
            @if($type == 'Radiology')

            <tr>
                <th>Scan Type</th>
                <td>
                    {{ $order->scanType->name ?? '-' }}
                </td>
            </tr>

            <tr>
                <th>Body Part</th>
                <td>{{ $order->body_part }}</td>
            </tr>

            <tr>
                <th>Priority</th>
                <td>{{ $order->priority }}</td>
            </tr>

            <tr>
                <th>Status</th>
                <td>{{ $order->status }}</td>
            </tr>

            @endif

@if($type == 'Medication')

<tr>
    <th>Patient Name</th>
    <td>
        {{ $order->first_name }}
        {{ $order->last_name }}
    </td>
</tr>

<tr>
    <th>Medicine</th>
    <td>
        {{ $order->medicine_name }}
    </td>
</tr>

<tr>
    <th>Dosage</th>
    <td>
        {{ $order->dosage }}
    </td>
</tr>

<tr>
    <th>Frequency</th>
    <td>
        {{ $order->frequency }}
    </td>
</tr>

@endif

        </table>

        <hr>

        <h5>Execute Order</h5>

   <form action="{{ route('admin.doctor-order-execution.execute', $order->id) }}"
      method="POST">

    @csrf

    <input type="hidden"
           name="type"
           value="{{ $type }}">

            <div class="mb-3">

                <label class="form-label">
                    Execution Remarks
                </label>

                <textarea
                    name="remarks"
                    class="form-control"
                    rows="3"
                    placeholder="Enter execution remarks"></textarea>

            </div>

            <button type="submit"
                    class="btn btn-success">

                <i class="feather-check-circle"></i>

                Execute Order

            </button>

        </form>

        <hr>

        <h5>Escalate Order</h5>

        <form action="{{ route('admin.doctor-order-execution.escalate', $order->id) }}"
              method="POST">

            @csrf
            <input type="hidden"
                   name="type"
                   value="{{ $type }}"> 
                   
            <div class="mb-3">

                <label class="form-label">
                    Escalation Reason
                </label>

                <textarea
                    name="reason"
                    class="form-control"
                    rows="3"
                    placeholder="Enter escalation reason"></textarea>

            </div>

            <button type="submit"
                    class="btn btn-danger">

                <i class="feather-alert-triangle"></i>

                Escalate Order

            </button>

        </form>

    </div>

</div>

</div>@endsection