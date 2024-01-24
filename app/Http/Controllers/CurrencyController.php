<?php

namespace App\Http\Controllers;

use App\Exceptions\DatabaseException;
use App\Exceptions\RequestValidationException;
use App\Models\Currency;
use App\Services\CurrencyConversion\CurrencyConversionInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CurrencyController extends Controller
{
    public function __construct(
        private CurrencyConversionInterface $currencyConversionService
    ) {
    }
    public function index()
    {
        $data = Currency::paginate(5);
        return view('components.currency-table', ['data' => $data]);
    }

    public function show(string $id)
    {
        try {
            $model = Currency::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return DatabaseException::modelNotFoundException('currency',$id)->render(null);
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
            return RequestValidationException::validationFail($validator->errors())->render($request);
        }
        try {
            $model = Currency::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return DatabaseException::modelNotFoundException('currency',$id)->render($request);
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
            return RequestValidationException::validationFail($validator->errors())->render($request);
        }
        try {
            $model = Currency::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return DatabaseException::modelNotFoundException('currency',$id)->render($request);
        }
        $order = $this->currencyConversionService->buy($model, $request->integer('amount'));
        return view('components.currency-order', ['order' => $order]);
    }
}
