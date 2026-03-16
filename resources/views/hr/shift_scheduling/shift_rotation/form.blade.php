@csrf

<div class="row">


<div class="col-xl-6">

<div class="card stretch stretch-full">

<div class="card-body">

<h5 class="mb-4">Rotation Setup</h5>


<div class="mb-3">

<label class="form-label">Employee *</label>

<select name="staff_id" class="form-control" required>

<option value="">Select Employee</option>

@foreach($staff as $id => $name)

<option value="{{ $id }}"
{{ old('staff_id',$rotation->staff_id ?? '') == $id ? 'selected' : '' }}>

{{ $name }}

</option>

@endforeach

</select>

</div>


<div class="mb-3">

<label class="form-label">First Shift *</label>

<select name="first_shift_id" class="form-control" required>

<option value="">Select Shift</option>

@foreach($shifts as $id => $shift)

<option value="{{ $id }}"
{{ old('first_shift_id',$rotation->first_shift_id ?? '') == $id ? 'selected' : '' }}>

{{ $shift }}

</option>

@endforeach

</select>

</div>


<div class="mb-3">

<label class="form-label">Second Shift *</label>

<select name="second_shift_id" class="form-control" required>

<option value="">Select Shift</option>

@foreach($shifts as $id => $shift)

<option value="{{ $id }}"
{{ old('second_shift_id',$rotation->second_shift_id ?? '') == $id ? 'selected' : '' }}>

{{ $shift }}

</option>

@endforeach

</select>

</div>

</div>
</div>
</div>



<div class="col-xl-6">

<div class="card stretch stretch-full">

<div class="card-body">

<h5 class="mb-4">Rotation Settings</h5>


<div class="mb-3">

<label class="form-label">Rotation Days *</label>

<input type="number"
name="rotation_days"
class="form-control"
value="{{ old('rotation_days',$rotation->rotation_days ?? '') }}"
required>

</div>


<div class="mb-3">

<label class="form-label">Start Date *</label>

<input type="date"
name="start_date"
class="form-control"
value="{{ old('start_date',$rotation->start_date ?? '') }}"
required>

</div>


<div class="mb-3">

<label class="form-label">Status *</label>

<select name="status" class="form-control">

<option value="1"
{{ old('status',$rotation->status ?? 1) == 1 ? 'selected' : '' }}>
Active
</option>

<option value="0"
{{ old('status',$rotation->status ?? 1) == 0 ? 'selected' : '' }}>
Inactive
</option>

</select>

</div>

</div>
</div>
</div>

</div>


<div class="text-end mt-3">

<button class="btn btn-primary">

{{ isset($rotation) ? 'Update Rotation' : 'Save Rotation' }}

</button>

</div>