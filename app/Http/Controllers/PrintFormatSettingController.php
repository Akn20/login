<?php

namespace App\Http\Controllers;

use App\Models\PrintFormatSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class PrintFormatSettingController extends Controller
{
    public function index()
    {
        $formats = PrintFormatSetting::all();

        return view(
            'admin.print_format_settings.index',
            compact('formats')
        );
    }

    public function create()
    {
        return view('admin.print_format_settings.create');
    }

  public function store(Request $request)
{
  $request->validate([
    'hospital_name' => 'required',
    'paper_size' => 'required',
    'orientation' => 'required',
    'hospital_logo' => 'nullable|file|max:10240',
    'margins' => 'nullable|numeric'
]);

    $logoPath = null;

    if ($request->hasFile('hospital_logo')) {

        $logoPath = $request->file('hospital_logo')
                            ->store('print_format_logos', 'public');
    }

    PrintFormatSetting::create([
        'hospital_id' => 1,
        'hospital_logo' => $logoPath,
        'hospital_name' => $request->hospital_name,
        'address' => $request->address,
        'phone_number' => $request->phone_number,
        'footer_text' => $request->footer_text,
        'disclaimer' => $request->disclaimer,
        'signature_area' => $request->signature_area,
        'paper_size' => $request->paper_size,
        'orientation' => $request->orientation,
        'margins' => $request->margins,
        'status' => $request->status
    ]);

    return redirect()
        ->route('print-format-settings.index')
        ->with('success', 'Print Format Added Successfully');
}

    public function show($id)
    {
        $format = PrintFormatSetting::findOrFail($id);

        return view(
            'admin.print_format_settings.show',
            compact('format')
        );
    }

    public function edit($id)
    {
        $format = PrintFormatSetting::findOrFail($id);

        return view(
            'admin.print_format_settings.edit',
            compact('format')
        );
    }

   public function update(Request $request, $id)
{
    $format = PrintFormatSetting::findOrFail($id);

    $request->validate([
    'hospital_name' => 'required',
    'paper_size' => 'required',
    'orientation' => 'required',
    'hospital_logo' => 'nullable|file|max:10240',
    'margins' => 'nullable|numeric'
]);

    $logoPath = $format->hospital_logo;

    if ($request->hasFile('hospital_logo')) {

        if (
            $format->hospital_logo &&
            Storage::disk('public')->exists($format->hospital_logo)
        ) {
            Storage::disk('public')->delete($format->hospital_logo);
        }

        $logoPath = $request->file('hospital_logo')
                            ->store('print_format_logos', 'public');
    }

    $format->update([
        'hospital_logo' => $logoPath,
        'hospital_name' => $request->hospital_name,
        'address' => $request->address,
        'phone_number' => $request->phone_number,
        'footer_text' => $request->footer_text,
        'disclaimer' => $request->disclaimer,
        'signature_area' => $request->signature_area,
        'paper_size' => $request->paper_size,
        'orientation' => $request->orientation,
        'margins' => $request->margins,
        'status' => $request->status
    ]);

    return redirect()
        ->route('print-format-settings.index')
        ->with('success', 'Print Format Updated Successfully');
}

    public function destroy($id)
    {
        $format = PrintFormatSetting::findOrFail($id);

        $format->delete();

        return redirect()
            ->route('print-format-settings.index')
            ->with('success', 'Print Format Deleted Successfully');
    }
}