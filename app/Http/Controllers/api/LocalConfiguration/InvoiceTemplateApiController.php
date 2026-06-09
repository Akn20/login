<?php

namespace App\Http\Controllers\Api\LocalConfiguration;

use App\Http\Controllers\Controller;
use App\Models\InvoiceTemplate;
use Illuminate\Http\Request;

class InvoiceTemplateApiController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => InvoiceTemplate::latest()->get()
        ]);
    }

    public function store(Request $request)
{
    $request->validate([
        'template_name' => 'required|string|max:255',
        'starting_number' => 'nullable|integer|min:1',
        'status' => 'nullable|in:Active,Inactive'
    ]);

    $template = InvoiceTemplate::create([
        'hospital_id' => 1,
        'template_name' => $request->template_name,
        'invoice_prefix' => $request->invoice_prefix,
        'starting_number' => $request->starting_number ?? 1,
        'show_logo' => $request->boolean('show_logo', true),
        'show_address' => $request->boolean('show_address', true),
        'show_phone' => $request->boolean('show_phone', true),
        'show_gst' => $request->boolean('show_gst', false),
        'terms_conditions' => $request->terms_conditions,
        'status' => $request->status ?? 'Active'
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Invoice Template Added Successfully',
        'data' => $template
    ], 201);
}

    public function show($id)
    {
        $template = InvoiceTemplate::find($id);

        if (!$template) {
            return response()->json([
                'success' => false,
                'message' => 'Invoice Template Not Found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $template
        ]);
    }

    public function update(Request $request, $id)
    {
        $template = InvoiceTemplate::find($id);

        if (!$template) {
            return response()->json([
                'success' => false,
                'message' => 'Invoice Template Not Found'
            ], 404);
        }

      $request->validate([
    'template_name' => 'required|string|max:255',
    'starting_number' => 'nullable|integer|min:1',
    'status' => 'nullable|in:Active,Inactive'
]);

        $template->update([
            'template_name' => $request->template_name,
            'invoice_prefix' => $request->invoice_prefix,
            'starting_number' => $request->starting_number,
           'show_logo' => $request->boolean('show_logo', true),
        'show_address' => $request->boolean('show_address', true),
        'show_phone' => $request->boolean('show_phone', true),
        'show_gst' => $request->boolean('show_gst', false),
            'terms_conditions' => $request->terms_conditions,
            'status' => $request->status
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Invoice Template Updated Successfully',
            'data' => $template->fresh()
        ]);
    }

    public function destroy($id)
    {
        $template = InvoiceTemplate::find($id);

        if (!$template) {
            return response()->json([
                'success' => false,
                'message' => 'Invoice Template Not Found'
            ], 404);
        }

        $template->delete();

        return response()->json([
            'success' => true,
            'message' => 'Invoice Template Deleted Successfully'
        ]);
    }
}