@extends('layouts.admin')

@section('page-title', 'Reassign Token | ' . config('app.name'))

@section('content')

<div class="nxl-content">

    <div class="page-header">
        <div class="page-header-left d-flex align-items-center">

            <div class="page-header-title">
                <h5 class="m-b-10">Reassign Token</h5>
            </div>

            <ul class="breadcrumb">
                <li class="breadcrumb-item">Receptionist</li>
                <li class="breadcrumb-item">Token & Queue Management</li>
                <li class="breadcrumb-item">Reassign</li>
            </ul>

        </div>
    </div>

    <div class="main-content">
        <div class="row">
            <div class="col-lg-12">

                <div class="card stretch stretch-full">

                    <div class="card-body">

                        <form action="{{ route('admin.tokens.update', $token->id) }}" method="POST">

                            @csrf
                            @method('PUT')

                            @include('admin.receptionist.tokens.form')

                            <div class="d-flex gap-2 mt-3">

                                <button type="submit" class="btn btn-primary">
                                    Update Token
                                </button>

                                <a href="{{ route('admin.tokens.index') }}" class="btn btn-light">
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