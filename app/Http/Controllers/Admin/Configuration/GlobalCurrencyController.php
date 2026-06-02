<?php

namespace App\Http\Controllers\Admin\Configuration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GlobalCurrency;

class GlobalCurrencyController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $currencies = GlobalCurrency::latest()
            ->paginate(10);

        return view(
            'admin.configuration.currency.index',
            compact('currencies')
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
            'admin.configuration.currency.create'
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

            'currency_name' => 'required',

            'currency_code' => 'required|unique:global_currencies,currency_code',

            'currency_symbol' => 'required',

            'decimal_places' => 'required|numeric|min:0|max:5'

        ]);

        /*
        |--------------------------------------------------------------------------
        | ONLY ONE DEFAULT CURRENCY
        |--------------------------------------------------------------------------
        */

        if ($request->is_default == 1) {

            GlobalCurrency::query()
                ->update([
                    'is_default' => false
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | CREATE
        |--------------------------------------------------------------------------
        */

        GlobalCurrency::create([

            'currency_name' => $request->currency_name,

            'currency_code' => strtoupper($request->currency_code),

            'currency_symbol' => $request->currency_symbol,

            'decimal_places' => $request->decimal_places,

            'is_default' => $request->is_default ?? false

        ]);

        return redirect()
            ->route('admin.configuration.currencies.index')
            ->with(
                'success',
                'Currency Created Successfully'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */

    public function edit($id)
    {
        $currency = GlobalCurrency::findOrFail($id);

        return view(
            'admin.configuration.currency.edit',
            compact('currency')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, $id)
    {
        $currency = GlobalCurrency::findOrFail($id);

        /*
        |--------------------------------------------------------------------------
        | VALIDATION
        |--------------------------------------------------------------------------
        */

        $request->validate([

            'currency_name' => 'required',

            'currency_code' => 'required|unique:global_currencies,currency_code,' . $id,

            'currency_symbol' => 'required',

            'decimal_places' => 'required|numeric|min:0|max:5'

        ]);

        /*
        |--------------------------------------------------------------------------
        | ONLY ONE DEFAULT CURRENCY
        |--------------------------------------------------------------------------
        */

        if ($request->is_default == 1) {

            GlobalCurrency::query()
                ->update([
                    'is_default' => false
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | UPDATE
        |--------------------------------------------------------------------------
        */

        $currency->update([

            'currency_name' => $request->currency_name,

            'currency_code' => strtoupper($request->currency_code),

            'currency_symbol' => $request->currency_symbol,

            'decimal_places' => $request->decimal_places,

            'is_default' => $request->is_default ?? false

        ]);

        return redirect()
            ->route('admin.configuration.currencies.index')
            ->with(
                'success',
                'Currency Updated Successfully'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */

    public function destroy($id)
    {
        $currency = GlobalCurrency::findOrFail($id);

        $currency->delete();

        return redirect()
            ->route('admin.configuration.currencies.index')
            ->with(
                'success',
                'Currency Deleted Successfully'
            );
    }
}
