<?php

namespace App\Http\Controllers\Api\Configuration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GlobalTimezone;

class GlobalTimezoneApiController extends Controller
{
    public function index()
    {
        $timezones = GlobalTimezone::latest()->get();

        return response()->json([
            'success' => true,
            'data' => $timezones
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([

            'timezone_name' => 'required',

            'timezone_code' => 'required',

            'date_format' => 'required',

            'time_format' => 'required'

        ]);

        if ($request->is_default == 1) {

            GlobalTimezone::query()
                ->update([
                    'is_default' => false
                ]);
        }

        $timezone = GlobalTimezone::create([

            'timezone_name' => $request->timezone_name,

            'timezone_code' => strtoupper($request->timezone_code),

            'date_format' => $request->date_format,

            'time_format' => $request->time_format,

            'is_default' => $request->is_default ?? false

        ]);

        return response()->json([

            'success' => true,

            'message' => 'Timezone Created Successfully',

            'data' => $timezone

        ], 201);
    }

    public function show($id)
    {
        $timezone = GlobalTimezone::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $timezone
        ]);
    }

    public function update(Request $request, $id)
    {
        $timezone = GlobalTimezone::findOrFail($id);

        $request->validate([

            'timezone_name' => 'required',

            'timezone_code' => 'required',

            'date_format' => 'required',

            'time_format' => 'required'

        ]);

        if ($request->is_default == 1) {

            GlobalTimezone::query()
                ->update([
                    'is_default' => false
                ]);
        }

        $timezone->update([

            'timezone_name' => $request->timezone_name,

            'timezone_code' => strtoupper($request->timezone_code),

            'date_format' => $request->date_format,

            'time_format' => $request->time_format,

            'is_default' => $request->is_default ?? false

        ]);

        return response()->json([

            'success' => true,

            'message' => 'Timezone Updated Successfully',

            'data' => $timezone

        ]);
    }

    public function destroy($id)
    {
        $timezone = GlobalTimezone::findOrFail($id);

        $timezone->delete();

        return response()->json([

            'success' => true,

            'message' => 'Timezone Deleted Successfully'

        ]);
    }
}
