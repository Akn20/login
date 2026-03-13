@extends('layouts.admin')

@section('content')

    <script>

        document.addEventListener("DOMContentLoaded", function () {

            const addBtn = document.getElementById("addMedicine");
            const table = document.querySelector("#medicineTable tbody");

            addBtn.addEventListener("click", function () {

                let newRow = `
            <tr>

            <td>
                <select name="medicine[]" class="form-control" required>
                    <option value="">Select</option>
                    @foreach($medicines as $medicine)
                        <option value="{{ $medicine->id }}">{{ $medicine->medicine_name }}</option>
                    @endforeach
                </select>
            </td>

            <td><input type="text" class="form-control" name="dosage[]" required></td>
            <td><input type="text" class="form-control" name="frequency[]" required></td>
            <td><input type="text" class="form-control" name="duration[]" required></td>
            <td><input type="text" class="form-control" name="instructions[]" required></td>

            <td>
                <button type="button" class="btn btn-danger" onclick="removeMedicine(this)">
                    <i class="feather-trash-2"></i> Remove
                </button>
            </td>

            </tr>
            `;

                table.insertAdjacentHTML("beforeend", newRow);

            });

        });

        function removeMedicine(btn) {
            btn.closest("tr").remove();
        }

    </script>


    <div class="container-fluid">

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="card">

            <div class="card-header">
                <h4>Edit Consultation</h4>
            </div>

            <div class="card-body">

                <!-- Patient Information -->

                <div class="card mb-3">

                    <div class="card-header">
                        <strong>Patient Information</strong>
                    </div>

                    <div class="card-body">

                        <div class="row">

                            <div class="col-md-3">
                                <label>Name</label>
                                <input type="text" class="form-control" value="{{ $patient->first_name }}" readonly>
                            </div>

                            <div class="col-md-2">
                                <label>Age</label>
                                <input type="text" class="form-control"
                                    value="{{ \Carbon\Carbon::parse($patient->date_of_birth)->age }}" readonly>
                            </div>

                            <div class="col-md-2">
                                <label>Gender</label>
                                <input type="text" class="form-control" value="{{ $patient->gender }}" readonly>
                            </div>

                            <div class="col-md-3">
                                <label>Blood Group</label>
                                <input type="text" class="form-control" value="{{ $patient->blood_group }}" readonly>
                            </div>

                        </div>

                    </div>
                </div>


                <form method="POST" action="{{ route('doctor.update-consultation', $consultation->id) }}">
                    @csrf


                    <!-- Symptoms -->

                    <div class="mb-3">

                        <label><strong>Symptoms</strong></label>

                        <textarea name="symptoms" class="form-control" rows="3"
                            required>{{ $consultation->symptoms }}</textarea>

                    </div>


                    <!-- Diagnosis -->

                    <div class="mb-3">

                        <label><strong>Diagnosis</strong></label>

                        <textarea name="diagnosis" class="form-control" rows="3"
                            required>{{ $consultation->diagnosis }}</textarea>

                    </div>



                    <!-- Prescription -->

                    <div class="card mb-3">

                        <div class="card-header">
                            <strong>Prescription</strong>

                            <button type="button" class="btn btn-primary" id="addMedicine">
                                + Add Medicine
                            </button>

                        </div>


                        <div class="card-body">

                            <table class="table table-bordered" id="medicineTable">

                                <thead>

                                    <tr>

                                        <th>Medicine</th>
                                        <th>Dosage</th>
                                        <th>Frequency</th>
                                        <th>Duration</th>
                                        <th>Instructions</th>
                                        <th>Action</th>

                                    </tr>

                                </thead>


                                <tbody>

                                    @foreach($consultation->medicines as $med)

                                        <tr>

                                            <td>

                                                <select name="medicine[]" class="form-control" required>

                                                    <option value="">Select</option>

                                                    @foreach($medicines as $medicine)

                                                        <option value="{{ $medicine->id }}" @if($medicine->id == $med->id) selected
                                                        @endif>

                                                            {{ $medicine->medicine_name }}

                                                        </option>

                                                    @endforeach

                                                </select>

                                            </td>


                                            <td>
                                                <input type="text" class="form-control" name="dosage[]"
                                                    value="{{ $med->pivot->dosage }}" required>
                                            </td>


                                            <td>
                                                <input type="text" class="form-control" name="frequency[]"
                                                    value="{{ $med->pivot->frequency }}" required>
                                            </td>


                                            <td>
                                                <input type="text" class="form-control" name="duration[]"
                                                    value="{{ $med->pivot->duration }}" required>
                                            </td>


                                            <td>
                                                <input type="text" class="form-control" name="instructions[]"
                                                    value="{{ $med->pivot->instructions }}" required>
                                            </td>


                                            <td>
                                                <button type="button" class="btn btn-danger" onclick="removeMedicine(this)">
                                                    <i class="feather-trash-2"></i> Remove
                                                </button>
                                            </td>

                                        </tr>

                                    @endforeach


                                </tbody>

                            </table>

                        </div>

                    </div>



                    <!-- Recommended Tests -->

                    <div class="mb-3">

                        <label><strong>Recommended Tests</strong></label>

                        <input type="text" name="tests" class="form-control" value="{{ $consultation->tests }}"
                            placeholder="Blood Test, X-Ray, MRI etc">

                    </div>



                    <!-- Referral Doctor -->

                    <div class="mb-3">

                        <label><strong>Referral Doctor</strong></label>

                        <select name="referral_doctor_id" class="form-control">

                            <option value="">Select Doctor</option>

                            @foreach($doctors as $doctor)

                                <option value="{{ $doctor->id }}" @if($consultation->referral_doctor_id == $doctor->id) selected
                                @endif>

                                    {{ $doctor->name }}

                                </option>

                            @endforeach

                        </select>

                    </div>



                    <!-- Buttons -->

                    <div class="text-center mt-4">

                        <button type="submit" class="btn btn-success">

                            Update Consultation

                        </button>

                    </div>


                </form>

            </div>

        </div>

    </div>

@endsection