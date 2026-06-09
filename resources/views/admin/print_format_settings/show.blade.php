@extends('layouts.admin')

@section('content')

<div class="main-content">

```
<div class="card">

    <div class="card-header">
        <h4>Print Format Details</h4>
    </div>

    <div class="card-body">

        <table class="table table-bordered">

            <tr>
                <th width="250">Hospital Name</th>
                <td>{{ $format->hospital_name }}</td>
            </tr>

            <tr>
                <th>Hospital Logo</th>

                <td>

                    @if($format->hospital_logo)

                        <a href="{{ asset('storage/'.$format->hospital_logo) }}"
                           target="_blank"
                           class="btn btn-info btn-sm">

                            View Uploaded File

                        </a>

                    @else

                        No File Uploaded

                    @endif

                </td>
            </tr>

            <tr>
                <th>Phone Number</th>
                <td>{{ $format->phone_number }}</td>
            </tr>

            <tr>
                <th>Address</th>
                <td>{{ $format->address }}</td>
            </tr>

            <tr>
                <th>Paper Size</th>
                <td>{{ $format->paper_size }}</td>
            </tr>

            <tr>
                <th>Orientation</th>
                <td>{{ $format->orientation }}</td>
            </tr>

            <tr>
                <th>Margins</th>
                <td>{{ $format->margins }}</td>
            </tr>

            <tr>
                <th>Footer Text</th>
                <td>{{ $format->footer_text }}</td>
            </tr>

            <tr>
                <th>Disclaimer</th>
                <td>{{ $format->disclaimer }}</td>
            </tr>

            <tr>
                <th>Signature Area</th>
                <td>{{ $format->signature_area }}</td>
            </tr>

            <tr>
                <th>Status</th>

                <td>

                    @if($format->status == 'Active')

                        <span class="badge bg-success">
                            Active
                        </span>

                    @else

                        <span class="badge bg-danger">
                            Inactive
                        </span>

                    @endif

                </td>

            </tr>

        </table>

        <a href="{{ route('print-format-settings.index') }}"
           class="btn btn-secondary">
            Back
        </a>

    </div>

</div>
```

</div>

@endsection
