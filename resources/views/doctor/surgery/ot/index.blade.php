@extends('layouts.admin')

@section('content')

<div class="container">

    <div class="d-flex justify-content-between mb-3">

        <h3>OT Management</h3>

        <div>
            <a href="{{ route('ot.create') }}" class="btn btn-primary me-2">
                Create OT Record
            </a>
            <a href="{{ route('surgery.index') }}" class="btn btn-secondary">
                Back to Surgeries
            </a>
        </div>

    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">

        <div class="card-header">
            <h5>OT Records</h5>
        </div>

        <div class="card-body">

            <table class="table table-bordered">

                <thead>

                    <tr>

                        <th>#</th>

                        <th>Patient</th>

                        <th>Patient Name</th>

                        <th>Surgery Type</th>

                        <th>OT Room Used</th>

                        <th>Start Time</th>

                        <th>End Time</th>

                        <th>Approval Status</th>

                        <th>Actions</th>

                    </tr>

                </thead>

                <tbody>

                @forelse($ots as $ot)

                    <tr>

                        <td>{{ $loop->iteration }}</td>

                        <td>{{ $ot->surgery->patient_id }}</td>

                        <td>{{ $ot->surgery->patient->first_name }} {{ $ot->surgery->patient->last_name }}</td>

                        <td>{{ $ot->surgery->surgery_type }}</td>

                        <td>{{ $ot->ot_room_used }}</td>

                        <td>{{ $ot->start_time }}</td>

                        <td>{{ $ot->end_time }}</td>

                        <td>
                            <div class="form-check form-switch">
                                <input class="form-check-input approval-toggle"
                                       type="checkbox"
                                       id="toggle-{{ $ot->id }}"
                                       data-id="{{ $ot->id }}"
                                       {{ $ot->approval_status == 'Approved' ? 'checked' : '' }}>
                                <label class="form-check-label" for="toggle-{{ $ot->id }}">
                                    {{ $ot->approval_status }}
                                </label>
                            </div>
                        </td>

                        <td class="text-end">
                            <div class="hstack gap-2 justify-content-end">
                                <a href="{{ route('ot.edit', $ot->id) }}"
                                    class="avatar-text avatar-md action-icon action-edit" title="Edit">
                                    <i class="feather-edit"></i>
                                </a>

                                <form action="{{ route('ot.destroy', $ot->id) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Are you sure you want to delete this OT record?');">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                        class="avatar-text avatar-md action-icon action-delete"
                                        title="Delete">
                                        <i class="feather-trash-2"></i>
                                    </button>
                                </form>
                            </div>
                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="9" class="text-center">
                            No OT Records Found
                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const toggles = document.querySelectorAll('.approval-toggle');

    toggles.forEach(toggle => {
        toggle.addEventListener('change', function() {
            const otId = this.getAttribute('data-id');
            const isChecked = this.checked;
            const label = this.nextElementSibling;

            // Update label text
            label.textContent = isChecked ? 'Approved' : 'Not Approved';

            // Send AJAX request to update status
            fetch(`{{ url('doctor/ot') }}/${otId}/toggle-status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    approval_status: isChecked ? 'Approved' : 'Not Approved'
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success message
                    showAlert('Status updated successfully!', 'success');
                } else {
                    // Revert toggle on error
                    this.checked = !isChecked;
                    label.textContent = !isChecked ? 'Approved' : 'Not Approved';
                    showAlert('Failed to update status.', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                // Revert toggle on error
                this.checked = !isChecked;
                label.textContent = !isChecked ? 'Approved' : 'Not Approved';
                showAlert('An error occurred.', 'error');
            });
        });
    });

    function showAlert(message, type) {
        // Remove existing alerts
        const existingAlerts = document.querySelectorAll('.alert');
        existingAlerts.forEach(alert => alert.remove());

        // Create new alert
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show`;
        alertDiv.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;

        // Insert at the top of the container
        const container = document.querySelector('.container');
        container.insertBefore(alertDiv, container.firstChild);

        // Auto-dismiss after 3 seconds
        setTimeout(() => {
            if (alertDiv.parentNode) {
                alertDiv.remove();
            }
        }, 3000);
    }
});
</script>

@endsection