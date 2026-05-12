@extends('layouts.admin')

@section('content')

    <script>
        document.addEventListener("DOMContentLoaded", function () {

            const addBtn = document.getElementById("addMapping");
            const table = document.querySelector("#mappingTable tbody");

            addBtn.addEventListener("click", function () {

                let index = table.rows.length;

                let newRow = `
        <tr>

            <td>
                <select name="test_name[]" class="form-control" required>
                    <option value="">Select Test</option>

                    @foreach($tests as $test)
                        <option value="{{ $test->test_name }}">
                            {{ $test->test_name }}
                        </option>
                    @endforeach
                </select>
            </td>

            <td>
                <select name="parameters[${index}][]" class="form-control select2" multiple required>
                    @foreach($parameters as $param)
                        <option value="{{ $param->id }}">
                            {{ $param->name }} ({{ $param->unit }})
                        </option>
                    @endforeach
                </select>
            </td>

            <td>
                <button type="button" class="btn btn-danger" onclick="removeRow(this)">
                    Remove
                </button>
            </td>

        </tr>
        `;

                table.insertAdjacentHTML("beforeend", newRow);

                $('.select2').select2();
            });

        });

        function removeRow(btn) {
            btn.closest("tr").remove();
        }
    </script>

    <script>
        $(document).ready(function () {
            $('.select2').select2({
                placeholder: "Select Parameters"
            });
        });
    </script>

    <!-- ✅ TOGGLE SCRIPT -->
    <script>
        function showMappings() {
            document.getElementById('mappingForm').style.display = 'none';
            document.getElementById('mappingTableSection').style.display = 'block';
        }

        function showForm() {
            document.getElementById('mappingForm').style.display = 'block';
            document.getElementById('mappingTableSection').style.display = 'none';
        }
    </script>

    <div class="container-fluid">

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="card">

            <div class="card-header d-flex justify-content-between align-items-center">
                <h4>Parameter Mapping</h4>

                <!-- ✅ NEW BUTTON -->
                <div>
                    <button type="button" class="btn btn-secondary me-2" onclick="showMappings()">
                        View Mappings
                    </button>


                </div>
            </div>

            <div class="card-body">

                <!-- ================= VIEW MAPPINGS ================= -->
                <div id="mappingTableSection" style="display:none;">

                    @if(isset($mappings) && count($mappings) > 0)

                        <div class="card mb-4">
                            <div class="card-header">
                                <h5>Existing Parameter Mappings</h5>
                            </div>

                            <div class="card-body">

                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Test Name</th>
                                            <th>Parameters</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        @foreach($mappings as $testName => $params)

                                            <tr>
                                                <td><strong>{{ $testName }}</strong></td>

                                                <td>
                                                    @foreach($params as $p)
                                                        <span class="badge bg-primary">
                                                            {{ $p->parameter->name }}
                                                        </span>
                                                    @endforeach
                                                </td>
                                            </tr>

                                        @endforeach

                                    </tbody>

                                </table>

                            </div>
                        </div>

                    @else
                        <p>No mappings found.</p>
                    @endif

                </div>

                <!-- ================= FORM ================= -->
                <div id="mappingForm">

                    <form method="POST" action="{{ route('admin.laboratory.test-parameters.store') }}">
                        @csrf

                        <div class="card mb-3">
                            <div class="card-header">
                                <strong>Test → Parameter Mapping</strong>

                                <button type="button" class="btn btn-primary float-end" id="addMapping">
                                    + Add Mapping
                                </button>
                            </div>

                            <div class="card-body">

                                <table class="table table-bordered" id="mappingTable">

                                    <thead>
                                        <tr>
                                            <th>Test Name</th>
                                            <th>Parameters</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        <tr>

                                            <td>
                                                <select name="test_name[]" class="form-control" required>
                                                    <option value="">Select Test</option>

                                                    @foreach($tests as $test)
                                                        <option value="{{ $test->test_name }}">
                                                            {{ $test->test_name }}
                                                        </option>
                                                    @endforeach

                                                </select>
                                            </td>

                                            <td>
                                                <select name="parameters[0][]" class="form-control select2" multiple
                                                    required>
                                                    @foreach($parameters as $param)
                                                        <option value="{{ $param->id }}">
                                                            {{ $param->name }} ({{ $param->unit }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>

                                            <td>
                                                <button type="button" class="btn btn-danger" onclick="removeRow(this)">
                                                    <i class="feather-trash-2"></i> Remove
                                                </button>
                                            </td>

                                        </tr>

                                    </tbody>

                                </table>

                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-success">
                                Save Mapping
                            </button>
                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

@endsection