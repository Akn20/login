@csrf

<div class="row">

<div class="col-xl-6">

<div class="card stretch stretch-full">

<div class="card-body">

<h5 class="mb-4">Weekly Off Details</h5>

<div class="mb-3">

<label class="form-label">Employee *</label>

<select name="staff_id" class="form-control" required>

<option value="">Select Employee</option>

@foreach($staff as $id => $name)

<option value="{{ $id }}"
{{ old('staff_id',$weeklyOff->staff_id ?? '')==$id?'selected':'' }}>
{{ $name }}
</option>

@endforeach

</select>

</div>

<div class="mb-3">

<label class="form-label">Weekly Off Day *</label>

<select name="week_day" class="form-control">

<option value="">Select Day</option>

@foreach(['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'] as $day)

<option value="{{ $day }}"
{{ old('week_day',$weeklyOff->week_day ?? '')==$day?'selected':'' }}>
{{ $day }}
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

<h5 class="mb-4">Additional Settings</h5>

<div class="mb-3">

<label class="form-label">Status</label>

<select name="status" class="form-control">

<option value="1"
{{ old('status',$weeklyOff->status ?? 1)==1?'selected':'' }}>
Active
</option>

<option value="0"
{{ old('status',$weeklyOff->status ?? 1)==0?'selected':'' }}>
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

{{ isset($weeklyOff) ? 'Update Weekly Off' : 'Save Weekly Off' }}

</button>

</div>