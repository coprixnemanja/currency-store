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
    public function index(){
        $data = Currency::paginate(5);
        return view('components.currency-table',['data'=>$data]);
    }

    public function show(string $id)
    {
        $model = Currency::find($id);
        if (is_null($model)) {
            return response(view('components.info.error', ['message' => "Can not find currency of id: $id in the DB."]), 500);
        }
        return view('components.buy-currency-modal', ['currency' => $model]);
    }

    public function calculatePrice(string $id, Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'amount' => ['required', 'integer', 'min:1', 'max:100000']
            ]
        );
        if ($validator->fails()) {
            return response(view('components.info.error', ['message' => "Amount must be a whole number between 1 and 100000!"]), 400);
        }
        $model = Currency::find($id);
        if (is_null($model)) {
            return response(view('components.info.error', ['message' => "Can not find currency of id: $id in the DB."]), 500);
        }
        return $this->currencyConversionService->calculatePriceInUSD($model, $request->integer('amount'));
    }

    public function buy(string $id, Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'amount' => ['required', 'integer', 'min:1', 'max:100000']
            ]
        );
        if ($validator->fails()) {
            return response(view('components.info.error', ['message' => "Amount must be a whole number between 1 and 100000!"]), 500);
        }
        $model = Currency::find($id);
        if (is_null($model)) {
            return response(view('components.info.error', ['message' => "Can not find currency of id: $id in the DB."]), 500);
        }
        $order = $this->currencyConversionService->buy($model, $request->integer('amount'));
        if ($order === false) {
            return response(view('components.info.error', ['message' => "Can not record your order. Please try again later."]), 500);
        }
        return view('components.currency-order', ['order' => $order]);
    }
}
