<?php

namespace App\Http\Controllers;

use App\Models\PaymentClass;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentClassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return PaymentClass::with([])
                    ->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = request()->validate([
            'name'              => 	'required|string|max:20',
			'comments'          => 	'nullable|string|max:100',
			'status_id'         => 	'required|integer|max:999999999',
			'user_id'           => 	'required|integer|max:999999999',
        ]);

        $paymentClass = paymentClass::create($request->all());

        return [ 'msj' => 'PaymentClass Agregado Correctamente', compact('paymentClass') ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PaymentClass  $paymentClass
     * @return \Illuminate\Http\Response
     */
    public function show(PaymentClass $paymentClass)
    {
        return $paymentClass;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PaymentClass  $paymentClass
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PaymentClass $paymentClass)
    {
        $validate = request()->validate([
            'name'              => 	'required|string|max:20',
			'comments'          => 	'nullable|string|max:100',
			'status_id'         => 	'required|integer|max:999999999',
			'user_id'           => 	'required|integer|max:999999999',
        ]);

        $paymentClass = $paymentClass->update($request->all());

        return [ 'msj' => 'PaymentClass Editado' , compact('paymentClass')];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PaymentClass  $paymentClass
     * @return \Illuminate\Http\Response
     */
    public function destroy(PaymentClass $paymentClass)
    {
        $paymentClass = $paymentClass->delete();
 
        return [ 'msj' => 'PaymentClass Eliminado' , compact('paymentClass')];
    }
}
