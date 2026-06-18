@extends('layouts.admin')

@section('content')

<div class="main-content">

    <div class="page-header">
        <h4>Emergency Contacts</h4>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">

        <div class="card-header d-flex justify-content-between">

            <h5>Emergency Contact List</h5>

            <a href="{{ route('emergency-contacts.create') }}"
               class="btn btn-primary">

                <i class="feather-plus"></i>
                Add Contact

            </a>

        </div>

        <div class="card-body">

            <table class="table table-bordered table-striped">

                <thead>

                    <tr>
                        <th>ID</th>
                        <th>Contact Type</th>
                        <th>Contact Name</th>
                        <th>Mobile Number</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th width="150">Actions</th>
                    </tr>

                </thead>

                <tbody>

                    @forelse($contacts as $contact)

                    <tr>

                        <td>{{ $contact->id }}</td>

                        <td>{{ $contact->contact_type }}</td>

                        <td>{{ $contact->contact_name }}</td>

                        <td>{{ $contact->mobile_no }}</td>

                        <td>{{ $contact->email }}</td>

                        <td>

                            @if($contact->status == 'Active')

                                <span class="badge bg-success">
                                    Active
                                </span>

                            @else

                                <span class="badge bg-danger">
                                    Inactive
                                </span>

                            @endif

                        </td>

             <td>

    <div class="d-flex align-items-center gap-2">

        <a href="{{ route('emergency-contacts.show',$contact->id) }}"
           class="btn btn-sm btn-light border"
           title="View">

            <i class="feather-eye text-info"></i>

        </a>

        <a href="{{ route('emergency-contacts.edit',$contact->id) }}"
           class="btn btn-sm btn-light border"
           title="Edit">

            <i class="feather-edit text-warning"></i>

        </a>

        <form action="{{ route('emergency-contacts.destroy',$contact->id) }}"
              method="POST"
              style="display:inline-block;">

            @csrf
            @method('DELETE')

            <button type="submit"
                    class="btn btn-sm btn-light border"
                    title="Delete"
                    onclick="return confirm('Delete this contact?')">

                <i class="feather-trash-2 text-danger"></i>

            </button>

        </form>

    </div>

</td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="7" class="text-center">

                            No Emergency Contacts Found

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection