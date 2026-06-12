<?php

namespace App\Http\Controllers\Admin\Configuration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GlobalTimezone;

class GlobalTimezoneController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $timezones = GlobalTimezone::latest()
            ->paginate(10);

        return view(
            'admin.configuration.timezone.index',
            compact('timezones')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        return view(
            'admin.configuration.timezone.create'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | VALIDATION
        |--------------------------------------------------------------------------
        */

        $request->validate([

            'timezone_name' => 'required',

            'timezone_code' => 'required',

            'date_format' => 'required',

            'time_format' => 'required'

        ]);

        /*
        |--------------------------------------------------------------------------
        | ONLY ONE DEFAULT TIMEZONE
        |--------------------------------------------------------------------------
        */

        if ($request->is_default == 1) {

            GlobalTimezone::query()
                ->update([
                    'is_default' => false
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | CREATE
        |--------------------------------------------------------------------------
        */

        GlobalTimezone::create([

            'timezone_name' => $request->timezone_name,

            'timezone_code' => strtoupper($request->timezone_code),

            'date_format' => $request->date_format,

            'time_format' => $request->time_format,

            'is_default' => $request->is_default ?? false

        ]);

        return redirect()
            ->route('admin.configuration.timezones.index')
            ->with(
                'success',
                'Timezone Created Successfully'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */

    public function edit($id)
    {
        $timezone = GlobalTimezone::findOrFail($id);

        return view(
            'admin.configuration.timezone.edit',
            compact('timezone')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, $id)
    {
        $timezone = GlobalTimezone::findOrFail($id);

        /*
        |--------------------------------------------------------------------------
        | VALIDATION
        |--------------------------------------------------------------------------
        */

        $request->validate([

            'timezone_name' => 'required',

            'timezone_code' => 'required',

            'date_format' => 'required',

            'time_format' => 'required'

        ]);

        /*
        |--------------------------------------------------------------------------
        | ONLY ONE DEFAULT TIMEZONE
        |--------------------------------------------------------------------------
        */

        if ($request->is_default == 1) {

            GlobalTimezone::query()
                ->update([
                    'is_default' => false
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | UPDATE
        |--------------------------------------------------------------------------
        */

        $timezone->update([

            'timezone_name' => $request->timezone_name,

            'timezone_code' => strtoupper($request->timezone_code),

            'date_format' => $request->date_format,

            'time_format' => $request->time_format,

            'is_default' => $request->is_default ?? false

        ]);

        return redirect()
            ->route('admin.configuration.timezones.index')
            ->with(
                'success',
                'Timezone Updated Successfully'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */

    public function destroy($id)
    {
        $timezone = GlobalTimezone::findOrFail($id);

        $timezone->delete();

        return redirect()
            ->route('admin.configuration.timezones.index')
            ->with(
                'success',
                'Timezone Deleted Successfully'
            );
    }
}
