<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $model = Currency::findOrFail($id);
        return view('components.buy-currency-modal', ['currency' => $model]);
    }

    public function calculatePrice(string $id, Request $request)
    {
        $validator = Validator::make($request->all(),[
                'amount' => ['required', 'integer', 'min:1']
            ],[
                'required' => 'The :attribute field is required.',
                'integer' => 'The :attribute must be a whole number.',
                'min:1' => 'The :attribute must be minimum 1.',
            ]
        );
        if($validator->fails()){
            return "Amount must be a whole number and minimum 1.";
        }
        $model = Currency::findOrFail($id);
        return "Price: $".round(($request->integer('amount') / $model->rate) * (1 + ($model->surcharge / 100)),4);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
