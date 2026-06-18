@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    <div class="card">

        <div class="card-header">

            <h4>
                Audit Details
            </h4>

        </div>

        <div class="card-body">

            <div class="mb-3">

                <strong>Module:</strong>

                {{ $log->module_name }}

            </div>

            <div class="mb-3">

                <strong>Action:</strong>

                {{ $log->action_type }}

            </div>

            <div class="mb-3">

                <strong>IP Address:</strong>

                {{ $log->ip_address }}

            </div>

            <div class="mb-3">

                <strong>Device Info:</strong>

                {{ $log->device_info }}

            </div>

            <hr>

            <h5>Old Value</h5>

            <pre>
{{ json_encode($log->old_value, JSON_PRETTY_PRINT) }}
            </pre>

            <hr>

            <h5>New Value</h5>

            <pre>
{{ json_encode($log->new_value, JSON_PRETTY_PRINT) }}
            </pre>

        </div>

    </div>

</div>

@endsection