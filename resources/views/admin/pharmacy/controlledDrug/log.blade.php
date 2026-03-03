@extends('layouts.admin')

@section('page-title', 'Controlled Drug Log | ' . config('app.name'))

@section('content')

    <div class="nxl-content">

        <div class="page-header">

            <div class="page-header-left d-flex align-items-center">

                <div class="page-header-title">

                    <h5>Controlled Drug Log</h5>

                </div>


                <ul class="breadcrumb">

                    <li class="breadcrumb-item">

                        Pharmacy

                    </li>

                    <li class="breadcrumb-item">

                        Controlled Drugs

                    </li>

                    <li class="breadcrumb-item">

                        Log

                    </li>

                </ul>

            </div>


            <div class="page-header-right ms-auto">

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

                                    <th>Type</th>

                                    <th>Quantity</th>

                                    <th>Date</th>

                                    <th>Pharmacist</th>

                                </tr>

                            </thead>



                            <tbody>

                                @foreach($logs as $index => $log)

                                    <tr>

                                        <td>{{ $index + 1 }}</td>

                                        <td>{{ $log->drug->drug_name }}
                                            - Batch {{ $log->drug->batch_number }}
                                        </td>

                                        <td>

                                            <span class="badge bg-soft-info text-info">

                                                {{ $log->transaction_type }}

                                            </span>

                                        </td>

                                        <td>{{ $log->quantity }}</td>

                                        <td>{{ $log->transaction_date }}</td>

                                        <td>{{ $log->pharmacist_id }}</td>

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