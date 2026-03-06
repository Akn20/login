@extends('layouts.admin')

@section('page-title', 'Deleted Controlled Drugs | ' . config('app.name'))

@section('content')

    <div class="nxl-content">

        <div class="page-header">

            <div class="page-header-left d-flex align-items-center">

                <div class="page-header-title">

                    <h5>Deleted Controlled Drugs</h5>

                </div>

            </div>

            <div class="page-header-right ms-auto d-flex gap-2">

                <a href="{{ route('admin.controlledDrug.index') }}" class="btn btn-neutral">

                    Back

                </a>

            </div>

        </div>



        <div class="main-content">

            <div class="card">

                <div class="card-body p-0">


                    <div class="table-responsive">

                        <table class="table table-hover">


                            <thead>

                                <tr>

                                    <th>Sl.No.</th>
                                    <th>Drug ID</th>
                                    <th>Batch</th>
                                    <th>Expiry</th>
                                    <th>Stock</th>
                                    <th>Supplier</th>

                                    <th class="text-end">

                                        Actions

                                    </th>

                                </tr>

                            </thead>


                            <tbody>

                                @foreach($controlledDrugs as $index => $drug)

                                    <tr>

                                        <td>{{ $index + 1 }}</td>

                                        <td>{{ $drug->drug_id }}</td>

                                        <td>{{ $drug->batch_number }}</td>

                                        <td>{{ $drug->expiry_date }}</td>

                                        <td>{{ $drug->stock_quantity }}</td>

                                        <td>{{ $drug->supplier_id }}</td>


                                        <td class="text-end">

                                            <div class="hstack gap-2 justify-content-end">


                                                <a href="{{ route('admin.controlledDrug.restore', $drug->controlled_drug_id) }}"
                                                    class="avatar-text avatar-md action-icon action-restore">

                                                    <i class="feather-refresh-ccw"></i>

                                                </a>



                                                <a href="{{ route('admin.controlledDrug.forceDelete', $drug->controlled_drug_id) }}"
                                                    class="avatar-text avatar-md action-icon action-delete"
                                                    onclick="return confirm('Permanent delete?')">

                                                    <i class="feather-trash"></i>

                                                </a>


                                            </div>

                                        </td>

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