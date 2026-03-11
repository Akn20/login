<div class="row">

<div class="col-md-6 mb-3">
<label class="form-label">Staff *</label>
<select name="staff_id" class="form-control" required>

<option value="">-- Select Staff --</option>

@foreach($staff as $s)
<option value="{{ $s->id }}"
{{ old('staff_id', $adjustment->staff_id ?? '') == $s->id ? 'selected' : '' }}>
{{ $s->name }}
</option>
@endforeach

</select>


</div>
<div class="col-md-12 mt-4">

<table class="table table-hover table-striped align-middle" id="leaveTable" border="1">
<thead class="table-light">
<tr>
<th>Leave Type</th>
<th>Default</th>
<th>Current Balance</th>
<th>Assign (+)</th>
<th>Debit (-)</th>
<th>New Balance</th>
</tr>
</thead>

<tbody id="leaveMappingContainer">
</tbody>

</table>

</div>









<div class="col-md-6 mb-3">
<label class="form-label">Year *</label>
<input type="number"
name="year"
class="form-control"
value="{{ old('year', $adjustment->year ?? date('Y')) }}"
required>
</div>


<div class="col-md-12 mb-3">
<label class="form-label">Remarks*</label>
<textarea
name="remarks"
class="form-control"
rows="3" required>{{ old('remarks', $adjustment->remarks ?? '') }}</textarea>
</div>

</div>


<div class="mt-4 d-flex justify-content-end gap-2">

<button type="submit" class="btn btn-primary btn-sm px-4">
<i class="feather-save me-1"></i>
{{ isset($adjustment) ? 'Update' : 'Save' }}
</button>

<a href="{{ route('hr.leave-adjustments.index') }}"
class="btn btn-light btn-sm px-4">
Cancel
</a>

</div>


<script>

document.addEventListener("DOMContentLoaded", function () {

    const staffSelect = document.querySelector('[name="staff_id"]');
    const container = document.getElementById("leaveMappingContainer");

    function loadLeaveMapping() {

        const staffId = staffSelect.value;

       if(!staffId){
    container.innerHTML = "";
    return;
}

        fetch("/hr/leave-adjustments/mapping/" + staffId)
        .then(res => res.json())
        .then(data => {

        setTimeout(() => {

document.querySelectorAll("#leaveTable tbody tr").forEach(row => {

const current = parseInt(row.querySelector(".current").innerText);

const assignInput = row.querySelector(".assign");
const debitInput = row.querySelector(".debit");
const newBalanceCell = row.querySelector(".newBalance");

function calculate(){

let assign = parseInt(assignInput.value) || 0;
let debit = parseInt(debitInput.value) || 0;

if(debit > current + assign){

alert("Debit cannot be greater than available leave");

debitInput.value = 0;
debit = 0;

}

let newBalance = current + assign - debit;

newBalanceCell.innerText = newBalance;

}

assignInput.addEventListener("input", calculate);
debitInput.addEventListener("input", calculate);

});

},100);

            container.innerHTML = "";
data.forEach(function(leave){

container.innerHTML += `
<tr>

<td>
${leave.leave_type.display_name}
<input type="hidden" name="leave_type_id[]" value="${leave.leave_type_id}">
</td>

<td class="default">${leave.accrual_value}</td>

<td class="current">${leave.current_balance}</td>

<td>
<input type="number" name="credit[]" class="form-control assign" value="0" min="0">
</td>

<td>
<input type="number" name="debit[]" class="form-control debit" value="0" min="0">
</td>

<td class="newBalance">${leave.current_balance}</td>

</tr>
`;

});

        });
    }

    staffSelect.addEventListener("change", loadLeaveMapping);

    // THIS LINE FIXES YOUR PROBLEM
    loadLeaveMapping();

});




</script>