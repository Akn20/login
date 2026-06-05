@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    {{-- PAGE HEADER --}}
    <div class="page-header mb-4">

        <div class="page-header-left">
            <h5 class="m-b-0">
                Add Laboratory Parameter
            </h5>
        </div>

        <div class="page-header-right ms-auto">

            <a href="{{ route('admin.laboratory.parameters.index') }}"
               class="btn btn-light">

                Back

            </a>

        </div>

    </div>

    {{-- CARD --}}
    <div class="card">

        <div class="card-body">

            <form method="POST"
                  action="{{ route('admin.laboratory.parameters.store') }}">

                @csrf

                <div class="row">

                    {{-- PARAMETER NAME --}}
                    <div class="col-md-6 mb-3">

                        <label>
                            Parameter Name
                        </label>

                        <input type="text"
                               name="name"
                               class="form-control"
                               placeholder="Enter parameter name"
                               required>

                    </div>

                    {{-- UNIT --}}
                    <div class="col-md-6 mb-3">

                        <label>
                            Unit
                        </label>

                        <input type="text"
                               name="unit"
                               class="form-control"
                               placeholder="Enter unit">

                    </div>

                    {{-- MIN VALUE --}}
                    <div class="col-md-6 mb-3">

                        <label>
                            Minimum Value
                        </label>

                        <input type="number"
                               step="0.01"
                               name="min_value"
                               class="form-control"
                               placeholder="Enter minimum value">

                    </div>

                    {{-- MAX VALUE --}}
                    <div class="col-md-6 mb-3">

                        <label>
                            Maximum Value
                        </label>

                        <input type="number"
                               step="0.01"
                               name="max_value"
                               class="form-control"
                               placeholder="Enter maximum value">

                    </div>

                </div>

                {{-- BUTTON --}}
                <button type="submit"
                        class="btn btn-success">

                    Save Parameter

                </button>

            </form>

        </div>

    </div>

</div>

@endsection