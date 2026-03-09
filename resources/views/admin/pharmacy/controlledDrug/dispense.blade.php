@extends('layouts.admin')

@section('page-title', 'Dispense Controlled Drug | ' . config('app.name'))

@section('content')

    <div class="nxl-content">

        <div class="page-header">

            <div class="page-header-left d-flex align-items-center">

                <div class="page-header-title">

                    <h5>Dispense Controlled Drug</h5>

                </div>


                <ul class="breadcrumb">

                    <li class="breadcrumb-item">Pharmacy</li>

                    <li class="breadcrumb-item">Controlled Drugs</li>

                    <li class="breadcrumb-item">

                        Dispense

                    </li>

                </ul>

            </div>

        </div>



        <div class="main-content">

            <div class="row justify-content-center">

                <div class="col-lg-6 col-md-8">


                    <div class="card stretch stretch-full">

                        <div class="card-body">


                            <form action="{{ route('admin.controlledDrug.dispenseStore') }}" method="POST">

                                @csrf


                                <div class="mb-4">

                                    <label class="form-label">

                                        Controlled Drug

                                    </label>

                                    <select name="controlled_drug_id" class="form-select" required>

                                        <option value="">
                                            Select Drug
                                        </option>

                                        @foreach($drugs as $drug)

                                            <option value="{{ $drug->controlled_drug_id }}">

                                                {{ $drug->drug_name }}
                                                - Batch {{ $drug->batch_number }}

                                            </option>

                                        @endforeach

                                    </select>

                                </div>



                                <div class="mb-4">

                                    <label class="form-label">

                                        Patient ID

                                    </label>

                                    <input type="text" name="patient_id" class="form-control">

                                </div>



                                <div class="mb-4">

                                    <label class="form-label">

                                        Prescription ID

                                    </label>

                                    <input type="text" name="prescription_id" class="form-control">

                                </div>



                                <div class="mb-4">

                                    <label class="form-label">

                                        Quantity Dispensed

                                    </label>

                                    <input type="number" name="quantity_dispensed" class="form-control">

                                    @error('quantity_dispensed')
                                        <small class="text-danger">
                                            {{ $message }}
                                        </small>
                                    @enderror

                                </div>



                                <div class="mb-4">

                                    <label class="form-label">

                                        Dispense Date

                                    </label>

                                    <input type="date" name="dispense_date" class="form-control">

                                    @error('dispense_date')
                                        <small class="text-danger">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>



                                <div class="mb-4">

                                    <label class="form-label">

                                        Pharmacist ID

                                    </label>

                                    <input type="text" name="pharmacist_id" class="form-control">

                                </div>


                                <div class="d-flex gap-2">


                                    <button class="btn btn-primary">

                                        Save

                                    </button>


                                    <a href="{{ route('admin.controlledDrug.dispenseIndex') }}" class="btn btn-light">

                                        Cancel

                                    </a>


                                </div>


                            </form>


                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection