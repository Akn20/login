@extends('layouts.admin')

@section('content')

<div class="container mt-4">

    <h2>Edit Case Sheet</h2>

    <form action="{{ route('admin.casesheets.update', $caseSheet->id) }}"
          method="POST">

        @csrf

        @method('PUT')

        <div class="mb-3">

            <label>Symptoms</label>

            <textarea name="symptoms"
                      class="form-control">{{ $caseSheet->symptoms }}</textarea>

        </div>

        <div class="mb-3">

            <label>Diagnosis</label>

            <textarea name="diagnosis"
                      class="form-control">{{ $caseSheet->diagnosis }}</textarea>

        </div>

        <div class="mb-3">

            <label>Clinical Notes</label>

            <textarea name="clinical_notes"
                      class="form-control">{{ $caseSheet->clinical_notes }}</textarea>

        </div>

        <div class="mb-3">

            <label>Status</label>

            <select name="status"
                    class="form-control">

                <option value="Active">Active</option>

                <option value="Completed">Completed</option>

                <option value="Discharged">Discharged</option>

            </select>

        </div>

        <button type="submit"
                class="btn btn-primary">

            Update

        </button>

    </form>

</div>

@endsection