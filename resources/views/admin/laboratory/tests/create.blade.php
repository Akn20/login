@extends('layouts.admin')

@section('content')
<h3>Add Lab Test</h3>

<form method="POST" action="{{ route('admin.laboratory.tests.store') }}">
@csrf

<label>Test Name</label>
<input type="text" name="test_name" class="form-control">

<label>Category</label>
<input type="text" name="category" class="form-control">

<label>Price</label>
<input type="text" name="price" class="form-control">

<button type="submit" class="btn btn-primary">Save</button>

</form>
@endsection