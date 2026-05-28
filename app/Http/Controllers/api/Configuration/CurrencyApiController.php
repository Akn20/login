<?php

namespace App\Http\Controllers\Api\Configuration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GlobalCurrency;

class CurrencyApiController extends Controller
{
    public function index()
    {
        $currencies = GlobalCurrency::latest()->get();

        return response()->json([
            'success' => true,
            'data' => $currencies
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([

            'currency_name' => 'required',

            'currency_code' => 'required',

            'currency_symbol' => 'required'

        ]);

        $currency = GlobalCurrency::create([

            'currency_name' => $request->currency_name,

            'currency_code' => strtoupper($request->currency_code),

            'currency_symbol' => $request->currency_symbol,

            'is_active' => $request->is_active ?? true

        ]);

        return response()->json([

            'success' => true,

            'message' => 'Currency Created Successfully',

            'data' => $currency

        ], 201);
    }

    public function show($id)
    {
        $currency = GlobalCurrency::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $currency
        ]);
    }

    public function update(Request $request, $id)
    {
        $currency = GlobalCurrency::findOrFail($id);

        $request->validate([

            'currency_name' => 'required',

            'currency_code' => 'required',

            'currency_symbol' => 'required'

        ]);

        $currency->update([

            'currency_name' => $request->currency_name,

            'currency_code' => strtoupper($request->currency_code),

            'currency_symbol' => $request->currency_symbol,

            'is_active' => $request->is_active ?? true

        ]);

        return response()->json([

            'success' => true,

            'message' => 'Currency Updated Successfully',

            'data' => $currency

        ]);
    }

    public function destroy($id)
    {
        $currency = GlobalCurrency::findOrFail($id);

        $currency->delete();

        return response()->json([

            'success' => true,

            'message' => 'Currency Deleted Successfully'

        ]);
    }
}
