@extends('layouts.admin')

@section('content')

<div class="container">

    <h3 class="mb-4">
        Edit GRN
    </h3>

    <form
        action="{{ route('admin.inventory.grns.update', $grn->id) }}"
        method="POST"
    >

        @csrf
        @method('PUT')

        <div class="card">

            <div class="card-body">

                <div class="mb-3">

                    <label class="form-label">
                        GRN Number
                    </label>

                    <input
                        type="text"
                        class="form-control"
                        value="{{ $grn->grn_number }}"
                        readonly
                    >

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Remarks
                    </label>

                    <textarea
                        name="remarks"
                        class="form-control"
                    >{{ $grn->remarks }}</textarea>

                </div>

                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    Update GRN
                </button>

            </div>

        </div>

    </form>

</div>

@endsection