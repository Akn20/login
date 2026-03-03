@extends('layouts.admin')

@section('page-title', 'Pharmacy | ' . config('app.name'))

@section('content')
    <div class="nxl-content">

        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Controlled Drug Management</h5>
                </div>

                <ul class="breadcrumb">
                    <li class="breadcrumb-item">Pharmacy</li>
                    <li class="breadcrumb-item">Controlled Drugs</li>
                </ul>
            </div>

            <div class="page-header-right ms-auto d-flex gap-2">

                <a href="{{ route('admin.controlledDrug.log') }}" class="btn btn-neutral">

                    Drug Log

                </a>


                <a href="{{ route('admin.controlledDrug.dispenseIndex') }}" class="btn btn-neutral">

                    Dispense Records

                </a>


                <a href="{{ route('admin.controlledDrug.trash') }}" class="btn btn-neutral">

                    Deleted Records

                </a>


                <a href="{{ route('admin.controlledDrug.create') }}" class="btn btn-neutral">

                    Add Controlled Drug

                </a>

            </div>
        </div>


        <div class="main-content">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card stretch stretch-full">
                        <div class="card-body p-0">

                            <div class="table-responsive">

                                <table class="table table-hover">
                                    <thead>
                                        <tr>

                                            <th>Sl.No.</th>

                                            <th>Drug Name</th>

                                            <th>Drug ID</th>

                                            <th>Batch</th>

                                            <th>Expiry</th>

                                            <th>Stock</th>

                                            <th>Supplier</th>

                                            <th>Status</th>

                                            <th class="text-end">
                                                Actions
                                            </th>

                                        </tr>
                                    </thead>



                                    <tbody>

                                        @foreach($controlledDrugs as $index => $drug)

                                            <tr>

                                                <td>{{ $index + 1 }}</td>

                                                <td>{{ $drug->drug_name }}</td>

                                                <td>{{ $drug->drug_id }}</td>

                                                <td>{{ $drug->batch_number }}</td>

                                                <td>{{ $drug->expiry_date }}</td>

                                                <td>{{ $drug->stock_quantity }}</td>

                                                <td>{{ $drug->supplier_id }}</td>


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


                                                <td class="text-end">

                                                    <div class="hstack gap-2 justify-content-end">


                                                        {{-- View --}}

                                                        <a href="{{ route('admin.controlledDrug.show', $drug->controlled_drug_id) }}"
                                                            class="avatar-text avatar-md action-icon">

                                                            <i class="feather-eye"></i>

                                                        </a>


                                                        {{-- Edit --}}

                                                        <a href="{{ route('admin.controlledDrug.edit', $drug->controlled_drug_id) }}"
                                                            class="avatar-text avatar-md action-icon action-edit">

                                                            <i class="feather-edit"></i>

                                                        </a>


                                                        {{-- Delete --}}

                                                        <form
                                                            action="{{ route('admin.controlledDrug.delete', $drug->controlled_drug_id) }}"
                                                            method="POST"
                                                            onsubmit="return confirm('Are you sure you want to delete this drug?')">

                                                            @csrf
                                                            @method('DELETE')

                                                            <button type="submit"
                                                                class="avatar-text avatar-md action-icon action-delete">

                                                                <i class="feather-trash-2"></i>

                                                            </button>

                                                        </form>


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

        </div>

    </div>
@endsection