<?php

namespace App\Http\Controllers;

use App\Models\InvoiceTemplate;
use Illuminate\Http\Request;

class InvoiceTemplateController extends Controller
{
    public function index()
    {
        $templates = InvoiceTemplate::all();

        return view(
            'admin.invoice_templates.index',
            compact('templates')
        );
    }

    public function create()
    {
        return view('admin.invoice_templates.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'template_name' => 'required'
        ]);

        InvoiceTemplate::create([
            'hospital_id' => 1,
            'template_name' => $request->template_name,
            'invoice_prefix' => $request->invoice_prefix,
            'starting_number' => $request->starting_number,
            'show_logo' => $request->has('show_logo'),
            'show_address' => $request->has('show_address'),
            'show_phone' => $request->has('show_phone'),
            'show_gst' => $request->has('show_gst'),
            'terms_conditions' => $request->terms_conditions,
            'status' => $request->status
        ]);

        return redirect()
            ->route('invoice-templates.index')
            ->with('success', 'Invoice Template Added Successfully');
    }

    public function show($id)
    {
        $template = InvoiceTemplate::findOrFail($id);

        return view(
            'admin.invoice_templates.show',
            compact('template')
        );
    }

    public function edit($id)
    {
        $template = InvoiceTemplate::findOrFail($id);

        return view(
            'admin.invoice_templates.edit',
            compact('template')
        );
    }

    public function update(Request $request, $id)
    {
        $template = InvoiceTemplate::findOrFail($id);

        $request->validate([
            'template_name' => 'required'
        ]);

        $template->update([
            'template_name' => $request->template_name,
            'invoice_prefix' => $request->invoice_prefix,
            'starting_number' => $request->starting_number,
            'show_logo' => $request->has('show_logo'),
            'show_address' => $request->has('show_address'),
            'show_phone' => $request->has('show_phone'),
            'show_gst' => $request->has('show_gst'),
            'terms_conditions' => $request->terms_conditions,
            'status' => $request->status
        ]);

        return redirect()
            ->route('invoice-templates.index')
            ->with('success', 'Invoice Template Updated Successfully');
    }

    public function destroy($id)
    {
        $template = InvoiceTemplate::findOrFail($id);

        $template->delete();

        return redirect()
            ->route('invoice-templates.index')
            ->with('success', 'Invoice Template Deleted Successfully');
    }
}