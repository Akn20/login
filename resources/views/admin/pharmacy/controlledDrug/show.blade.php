@extends('layouts.admin')

@section('page-title', 'Controlled Drug Details | ' . config('app.name'))

@section('content')

    <div class="nxl-content">


        <div class="page-header">

            <div class="page-header-left d-flex align-items-center">

                <div class="page-header-title">
                    <h5>Controlled Drug Details</h5>
                </div>

                <ul class="breadcrumb">
                    <li class="breadcrumb-item">Pharmacy</li>
                    <li class="breadcrumb-item">Controlled Drugs</li>
                    <li class="breadcrumb-item">View</li>
                </ul>

            </div>


            <div class="page-header-right ms-auto d-flex gap-2">

                <a href="{{ route('admin.controlledDrug.edit', $drug->controlled_drug_id) }}" class="btn btn-neutral">

                    Edit Drug

                </a>


                <a href="{{ route('admin.controlledDrug.index') }}" class="btn btn-neutral">

                    Back

                </a>

            </div>

        </div>



        <div class="main-content">

            <div class="row">


                {{-- Drug Information --}}

                <div class="col-lg-4">

                    <div class="card stretch stretch-full">

                        <div class="card-header">
                            <h5 class="card-title">Drug Information</h5>
                        </div>

                        <div class="card-body">

                            <table class="table table-borderless mb-0">


                                <tr>
                                    <th class="ps-0">Drug Name</th>
                                    <td>{{ $drug->drug_name }}</td>
                                </tr>


                                <tr>
                                    <th class="ps-0">Drug ID</th>
                                    <td>{{ $drug->drug_id }}</td>
                                </tr>


                                <tr>
                                    <th class="ps-0">Batch Number</th>
                                    <td>{{ $drug->batch_number }}</td>
                                </tr>


                                <tr>
                                    <th class="ps-0">Expiry Date</th>
                                    <td>{{ $drug->expiry_date }}</td>
                                </tr>


                                <tr>
                                    <th class="ps-0">Stock Quantity</th>
                                    <td>{{ $drug->stock_quantity }}</td>
                                </tr>


                                <tr>
                                    <th class="ps-0">Supplier ID</th>
                                    <td>{{ $drug->supplier_id }}</td>
                                </tr>


                                <tr>
                                    <th class="ps-0">Status</th>

                                    <td>

                                        @if($drug->status == 'Active')

                                            <span class="badge bg-soft-success text-success">

                                                Active

                                            </span>

                                        @else

                                            <span class="badge bg-soft-danger text-danger">

                                                Inactive

                                            </span>

                                        @endif

                                    </td>

                                </tr>


                            </table>

                        </div>

                    </div>

                </div>



                {{-- Dispense Records --}}

                <div class="col-lg-4">

                    <div class="card stretch stretch-full">

                        <div class="card-header">
                            <h5 class="card-title">Dispense Records</h5>
                        </div>

                        <div class="card-body">

                            @forelse($drug->dispenses as $dispense)

                                <table class="table table-borderless mb-3">

                                    <tr>
                                        <th class="ps-0">Patient ID</th>
                                        <td>{{ $dispense->patient_id }}</td>
                                    </tr>

                                    <tr>
                                        <th class="ps-0">Prescription ID</th>
                                        <td>{{ $dispense->prescription_id }}</td>
                                    </tr>

                                    <tr>
                                        <th class="ps-0">Quantity</th>
                                        <td>{{ $dispense->quantity_dispensed }}</td>
                                    </tr>

                                    <tr>
                                        <th class="ps-0">Dispense Date</th>
                                        <td>{{ $dispense->dispense_date }}</td>
                                    </tr>

                                    <tr>
                                        <th class="ps-0">Pharmacist ID</th>
                                        <td>{{ $dispense->pharmacist_id }}</td>
                                    </tr>

                                </table>

                                <hr>

                            @empty

                                <p class="text-muted">

                                    No dispense records found.

                                </p>

                            @endforelse

                        </div>

                    </div>

                </div>



                {{-- Drug Logs --}}

                {{-- Drug Logs --}}
                <div class="col-lg-4">

                    <div class="card stretch stretch-full">

                        <div class="card-header">
                            <h5 class="card-title">Drug Logs</h5>
                        </div>

                        <div class="card-body">

                            @forelse($drug->logs as $log)

                                <table class="table table-borderless mb-3">

                                    <tr>
                                        <th class="ps-0">Action</th>
                                        <td>{{ $log->action ?? '-' }}</td>
                                    </tr>

                                    <tr>
                                        <th class="ps-0">Quantity</th>
                                        <td>{{ $log->quantity ?? '-' }}</td>
                                    </tr>

                                    <tr>
                                        <th class="ps-0">Remarks</th>
                                        <td>{{ $log->remarks ?? '-' }}</td>
                                    </tr>

                                    <tr>
                                        <th class="ps-0">Date</th>
                                        <td>{{ $log->created_at }}</td>
                                    </tr>

                                </table>

                                <hr>

                            @empty

                                <p class="text-muted">
                                    No log records found.
                                </p>

                            @endforelse

                        </div>

                    </div>

                </div>


            </div>

        </div>

    </div>

@endsection