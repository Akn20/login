@extends('layouts.admin')

@section('page-title', 'Dispense Records | ' . config('app.name'))

@section('content')

    <div class="nxl-content">

        <div class="page-header">

            <div class="page-header-left d-flex align-items-center">

                <div class="page-header-title">

                    <h5>Dispense Records</h5>

                </div>


                <ul class="breadcrumb">

                    <li class="breadcrumb-item">

                        Pharmacy

                    </li>

                    <li class="breadcrumb-item">

                        Controlled Drugs

                    </li>

                    <li class="breadcrumb-item">

                        Dispense Records

                    </li>

                </ul>

            </div>


            <div class="page-header-right ms-auto d-flex gap-2">


                <a href="{{ route('admin.controlledDrug.dispenseCreate') }}" class="btn btn-neutral">

                    New Dispense

                </a>


                <a href="{{ route('admin.controlledDrug.index') }}" class="btn btn-neutral">

                    Back

                </a>


            </div>

        </div>



        <div class="main-content">

            <div class="card stretch stretch-full">

                <div class="card-body p-0">


                    <div class="table-responsive">


                        <table class="table table-hover">


                            <thead>

                                <tr>

                                    <th>Sl.No.</th>

                                    <th>Drug Name</th>

                                    <th>Patient</th>

                                    <th>Prescription</th>

                                    <th>Quantity</th>

                                    <th>Date</th>

                                    <th>Pharmacist</th>

                                </tr>

                            </thead>



                            <tbody>

                                @foreach($dispenses as $index => $dispense)

                                    <tr>

                                        <td>{{ $index + 1 }}</td>

                                        <td>{{ $dispense->drug->drug_name ?? 'N/A' }}
                                            - Batch {{ $dispense->drug->batch_number }}
                                        </td>
                                        <td>{{ $dispense->patient_id }}</td>

                                        <td>{{ $dispense->prescription_id }}</td>

                                        <td>{{ $dispense->quantity_dispensed }}</td>

                                        <td>{{ $dispense->dispense_date }}</td>

                                        <td>{{ $dispense->pharmacist_id }}</td>

                                    </tr>

                                @endforeach


                            </tbody>

                        </table>

                    </div>


                </div>

            </div>

        </div>

    </div>

@endsection