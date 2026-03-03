@extends('layouts.admin')

@section('page-title', 'Edit Controlled Drug | ' . config('app.name'))

@section('content')

    <div class="nxl-content">

        <div class="page-header">

            <div class="page-header-left d-flex align-items-center">

                <div class="page-header-title">
                    <h5>Edit Controlled Drug</h5>
                </div>

                <ul class="breadcrumb">
                    <li class="breadcrumb-item">Pharmacy</li>
                    <li class="breadcrumb-item">Controlled Drugs</li>
                    <li class="breadcrumb-item">Edit</li>
                </ul>

            </div>

        </div>


        <div class="main-content">

            <div class="row justify-content-center">

                <div class="col-lg-6 col-md-8">

                    <div class="card stretch stretch-full">

                        <div class="card-body">

                            <form action="{{ route('admin.controlledDrug.update', $drug->controlled_drug_id) }}"
                                method="POST">

                                @csrf

                                @include('admin.pharmacy.controlledDrug.form')


                                <div class="d-flex gap-2">

                                    <button class="btn btn-primary">

                                        Update

                                    </button>


                                    <a href="{{ route('admin.controlledDrug.index') }}" class="btn btn-light">

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