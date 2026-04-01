@extends('layouts.admin')

@section('title', 'Create Sales Return')

@section('content')
<div class="container-fluid">

    <h4>Create Sales Return</h4>
    @if(session('error'))
<div class="alert alert-danger">
    {{ session('error') }}
</div>
@endif
    {{-- BILL SEARCH --}}
    <form method="GET" action="{{ route('admin.salesReturn.create') }}">
        <div class="row mb-3">
            <div class="col-md-4">
                <input type="text" name="bill_no" 
                    class="form-control"
                    placeholder="Enter Bill Number"
                    value="{{ request('bill_no') }}">
            </div>
            <div class="col-md-2">
                <button class="btn btn-primary">Search</button>
            </div>
        </div>
    </form>

    @if($bill)

    {{-- RETURN FORM --}}
    <form method="POST" action="{{ route('admin.salesReturn.store') }}">
        @csrf
@if($bill)
    <input type="hidden" name="bill_id" value="{{ $bill->bill_id }}">
    <input type="hidden" name="patient_id" value="{{ $bill->patient_id }}">
@endif

        <div class="card">
            <div class="card-header">
                Bill: {{ $bill->bill_number }} |
                Patient: {{ $bill->patient->id ?? '' }}
            </div>

            <div class="card-body">

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Medicine</th>
                            <th>Batch</th>
                            <th>Sold Qty</th>
                            <th>Return Qty</th>
                            <th>Unit Price</th>
                        </tr>
                    </thead>

                    <tbody>

 @foreach($billItems as $key => $item)
<tr>

<td>{{ $item->medicine->medicine_name }}</td>

<td>{{ $item->batch->batch_number }}</td>

<td>{{ $item->quantity }}</td>

<td>
<input type="number"
       name="items[{{$key}}][return_qty]"
       class="form-control"
       min="0">
</td>

<td>

<input type="hidden"
       name="items[{{$key}}][medicine_id]"
       value="{{$item->medicine_id}}">

<input type="hidden"
       name="items[{{$key}}][batch_id]"
       value="{{$item->batch_id}}">

<input type="hidden"
       name="items[{{$key}}][unit_price]"
       value="{{$item->unit_price}}">

{{$item->unit_price}}

</td>

</tr>
@endforeach

                    </tbody>
                </table>

            </div>
        </div>

        <div class="mt-3">
            <button type="submit" class="btn btn-primary">Save Draft</button>
        </div>

    </form>

    @endif

</div>
<script>
document.querySelectorAll('.return-qty').forEach(function(input) {

    input.addEventListener('input', function() {

        let soldQty = parseInt(this.dataset.sold);
        let returnQty = parseInt(this.value);

        if(returnQty > soldQty){
            alert("Return quantity cannot exceed sold quantity");

            this.value = soldQty;
        }

    });

});
</script>
@endsection