<form action="{{ route('hr.leave-application.store') }}" method="POST" enctype="multipart/form-data">

@csrf

<div class="row">

    {{-- Staff --}}
    <div class="col-md-6 mb-3">

        <label class="form-label">Staff</label>


<select name="staff_id"
        class="form-control"
        required>

            <option value="">Select Staff</option>

            @foreach($staffList as $staff)

                <option value="{{ $staff->id }}"
                    {{ isset($staffId) && $staffId == $staff->id ? 'selected' : '' }}>

                    {{ $staff->name }}

                </option>

            @endforeach

        </select>

    </div>



    {{-- Leave Type --}}
    <div class="col-md-6 mb-3">

        <label class="form-label">Leave Type</label>

        <select name="leave_type_id"
                class="form-control"
                required>

            <option value="">Select Leave Type</option>

            @foreach($leaveTypes as $type)

                <option value="{{ $type->id }}">

                    {{ $type->display_name }}

                </option>

            @endforeach

        </select>

    </div>


    {{-- Leave Duration --}}
    <div class="col-md-6 mb-3">

        <label class="form-label">Leave Duration</label>

        <select name="leave_duration"
                class="form-control">

            <option value="full_day">
                Full Day
            </option>

            <option value="first_half">
                First Half
            </option>

            <option value="second_half">
                Second Half
            </option>

        </select>

    </div>


    {{-- Purpose --}}
    <div class="col-md-6 mb-3">

        <label class="form-label">Purpose</label>

        <textarea name="reason"
                  class="form-control"
                  rows="3"></textarea>

    </div>


    {{-- From Date --}}
    <div class="col-md-6 mb-3">

        <label class="form-label">From Date</label>

        <input type="date"
               name="from_date"
               class="form-control"
               required>

    </div>


    {{-- To Date --}}
    <div class="col-md-6 mb-3">

        <label class="form-label">To Date</label>

        <input type="date"
               name="to_date"
               class="form-control"
               required>

    </div>


    {{-- Attachment --}}
    <div class="col-md-6 mb-3">

        <label class="form-label">Attachment</label>

        <input type="file"
               name="attachment"
               class="form-control">

    </div>

</div>


<div class="mt-4 d-flex gap-2">

    <button type="submit"
            class="btn btn-primary text-uppercase">

        Save

    </button>

    <a href="{{ route('hr.leave-application.index') }}"
       class="btn btn-light text-uppercase">

        Cancel

    </a>

</div>

</form>
