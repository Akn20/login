<?php

namespace App\Http\Controllers;

use App\Models\EmergencyContact;
use Illuminate\Http\Request;

class EmergencyContactController extends Controller
{
    public function index()
    {
        $contacts = EmergencyContact::all();

        return view(
            'emergency_contacts.index',
            compact('contacts')
        );
    }

    public function create()
    {
        return view('emergency_contacts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'contact_type' => 'required',
            'contact_name' => 'required',
            'mobile_no' => 'required'
        ]);

        EmergencyContact::create([
            'hospital_id' => 1,
            'contact_type' => $request->contact_type,
            'contact_name' => $request->contact_name,
            'mobile_no' => $request->mobile_no,
            'alternate_no' => $request->alternate_no,
            'email' => $request->email,
            'address' => $request->address,
            'status' => $request->status
        ]);

        return redirect()
            ->route('emergency-contacts.index')
            ->with('success', 'Contact Added Successfully');
    }

    public function show($id)
    {
        $contact = EmergencyContact::findOrFail($id);

        return view(
            'emergency_contacts.show',
            compact('contact')
        );
    }

    public function edit($id)
    {
        $contact = EmergencyContact::findOrFail($id);

        return view(
            'emergency_contacts.edit',
            compact('contact')
        );
    }

    public function update(Request $request, $id)
    {
        $contact = EmergencyContact::findOrFail($id);

        $request->validate([
            'contact_type' => 'required',
            'contact_name' => 'required',
            'mobile_no' => 'required'
        ]);

        $contact->update([
            'contact_type' => $request->contact_type,
            'contact_name' => $request->contact_name,
            'mobile_no' => $request->mobile_no,
            'alternate_no' => $request->alternate_no,
            'email' => $request->email,
            'address' => $request->address,
            'status' => $request->status
        ]);

        return redirect()
            ->route('emergency-contacts.index')
            ->with('success', 'Contact Updated Successfully');
    }

    public function destroy($id)
    {
        $contact = EmergencyContact::findOrFail($id);

        $contact->delete();

        return redirect()
            ->route('emergency-contacts.index')
            ->with('success', 'Contact Deleted Successfully');
    }
}