<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Services\CurrencyConversion\CurrencyConversionInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CurrencyController extends Controller
{
    public function __construct(
        private CurrencyConversionInterface $currencyConversionService
    ) {
    }

    public function show(string $id)
    {
        $model = Currency::findOrFail($id);
        return view('components.buy-currency-modal', ['currency' => $model]);
    }

    public function calculatePrice(string $id, Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'amount' => ['required', 'integer', 'min:1']
            ],
            [
                'required' => 'The :attribute field is required.',
                'integer' => 'The :attribute must be a whole number.',
                'min:1' => 'The :attribute must be minimum 1.',
            ]
        );
        if ($validator->fails()) {
            return "Amount must be a whole number and minimum 1.";
        }
        $model = Currency::findOrFail($id);
        return "Price: $" . $this->currencyConversionService->calculatePriceInUSD($model,$request->integer('amount'));
    }
}
