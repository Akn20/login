<?php

namespace App\Http\Controllers\Api\LocalConfiguration;

use App\Http\Controllers\Controller;
use App\Models\PrintFormatSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PrintFormatApiController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => PrintFormatSetting::all()
        ]);
    }

   public function store(Request $request)
{
    $validated = $request->validate([
        'hospital_name' => 'required|string|max:255',
        'paper_size' => 'required|in:A4,A5,Letter',
        'orientation' => 'required|in:Portrait,Landscape',
        'margins' => 'nullable',
    ]);

    $format = PrintFormatSetting::create([
        'hospital_id' => 1,
        'hospital_name' => $request->hospital_name,
        'address' => $request->address,
        'phone_number' => $request->phone_number,
        'footer_text' => $request->footer_text,
        'disclaimer' => $request->disclaimer,
        'signature_area' => $request->signature_area,
        'paper_size' => $request->paper_size,
        'orientation' => $request->orientation,
        'margins' => $request->margins,
        'status' => $request->status ?? 'Active',
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Print Format Added Successfully',
        'data' => $format,
    ], 201);
}

    public function show($id)
    {
        $format = PrintFormatSetting::find($id);

        if (!$format) {
            return response()->json([
                'success' => false,
                'message' => 'Print Format Not Found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $format
        ]);
    }

    public function update(Request $request, $id)
    {
        $format = PrintFormatSetting::find($id);

        if (!$format) {
            return response()->json([
                'success' => false,
                'message' => 'Print Format Not Found'
            ], 404);
        }

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

        return response()->json([
            'success' => true,
            'message' => 'Print Format Updated Successfully',
            'data' => $format->fresh()
        ]);
    }

    public function destroy($id)
    {
        $format = PrintFormatSetting::find($id);

        if (!$format) {
            return response()->json([
                'success' => false,
                'message' => 'Print Format Not Found'
            ], 404);
        }

        if (
            $format->hospital_logo &&
            Storage::disk('public')->exists($format->hospital_logo)
        ) {
            Storage::disk('public')->delete($format->hospital_logo);
        }

        $format->delete();

        return response()->json([
            'success' => true,
            'message' => 'Print Format Deleted Successfully'
        ]);
    }
}