@extends('layouts.admin')

@section('content')
    <div class="container">

        <h3 class="mb-3">Edit Work Status</h3>

        <div class="card">
            <div class="card-body">

                <form action="{{ route('admin.work-status.update', $workStatus->id) }}" method="POST">
                    @csrf

                    @include('masters.work_status.form')


                    <div class="d-flex gap-2 mt-3">
                        <button type="submit" class="btn btn-primary">
                            Update
                        </button>

                        <a href="{{ route('admin.work-status.index') }}" class="btn btn-secondary">
                            Cancel
                        </a>
                    </div>

                </form>

            </div>
        </div>

    </div>
@endsection