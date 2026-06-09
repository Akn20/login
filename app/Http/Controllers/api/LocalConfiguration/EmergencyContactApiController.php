<?php

namespace App\Http\Controllers\Api\LocalConfiguration;

use App\Http\Controllers\Controller;
use App\Models\EmergencyContact;
use Illuminate\Http\Request;

class EmergencyContactApiController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => EmergencyContact::all()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'contact_type' => 'required',
            'contact_name' => 'required',
            'mobile_no' => 'required'
        ]);

        $contact = EmergencyContact::create([
            'hospital_id' => $request->hospital_id ?? 1,
            'contact_type' => $request->contact_type,
            'contact_name' => $request->contact_name,
            'mobile_no' => $request->mobile_no,
            'alternate_no' => $request->alternate_no,
            'email' => $request->email,
            'address' => $request->address,
            'status' => $request->status ?? 'Active'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Contact Added Successfully',
            'data' => $contact
        ], 201);
    }

    public function show($id)
    {
        $contact = EmergencyContact::find($id);

        if (!$contact) {
            return response()->json([
                'success' => false,
                'message' => 'Contact Not Found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $contact
        ]);
    }

    public function update(Request $request, $id)
    {
        $contact = EmergencyContact::find($id);

        if (!$contact) {
            return response()->json([
                'success' => false,
                'message' => 'Contact Not Found'
            ], 404);
        }

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

        return response()->json([
            'success' => true,
            'message' => 'Contact Updated Successfully',
            'data' => $contact->fresh()
        ]);
    }

    public function destroy($id)
    {
        $contact = EmergencyContact::find($id);

        if (!$contact) {
            return response()->json([
                'success' => false,
                'message' => 'Contact Not Found'
            ], 404);
        }

        $contact->delete();

        return response()->json([
            'success' => true,
            'message' => 'Contact Deleted Successfully'
        ]);
    }
}