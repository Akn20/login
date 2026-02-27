
@extends('layouts.admin')
@section('content')
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <h5 class="m-b-10">Create Module</h5>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">

      <form action="{{ route('admin.modules.store') }}" method="POST">
    @csrf

    @include('admin.modules.form')

</form>


    </div>
</div>

@endsection