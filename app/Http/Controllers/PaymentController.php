<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Payment::with([])
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
			'grupo'             => 	'required|string|max:20',
			'profile_id'        => 	'required|integer|max:999999999',
			'bonus_type_id'     => 	'required|integer|max:999999999',
			'start_at'          => 	'required|integer|max:999999999',
			'end_at'            => 	'required|integer|max:999999999',
			'payment_class_id'  => 	'required|integer|max:999999999',
			'ammount'           => 	'required|numeric|max:9',
			'times'             => 	'required|integer|max:999999999',
			'comments'          => 	'nullable|string|max:100',
			'status_id'         => 	'required|integer|max:999999999',
			'user_id'           => 	'required|integer|max:999999999',
        ]);

        $payment = payment::create($request->all());

        return [ 'msj' => 'Payment Agregado Correctamente', compact('payment') ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show(Payment $payment)
    {
        return $payment;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payment $payment)
    {
        $validate = request()->validate([
            'name'              => 	'required|string|max:20',
			'grupo'             => 	'required|string|max:20',
			'profile_id'        => 	'required|integer|max:999999999',
			'bonus_type_id'     => 	'required|integer|max:999999999',
			'start_at'          => 	'required|integer|max:999999999',
			'end_at'            => 	'required|integer|max:999999999',
			'payment_class_id'  => 	'required|integer|max:999999999',
			'ammount'           => 	'required|numeric|max:9',
			'times'             => 	'required|integer|max:999999999',
			'comments'          => 	'nullable|string|max:100',
			'status_id'         => 	'required|integer|max:999999999',
			'user_id'           => 	'required|integer|max:999999999',
        ]);

        $payment = $payment->update($request->all());

        return [ 'msj' => 'Payment Editado' , compact('payment')];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment)
    {
        $payment = $payment->delete();
 
        return [ 'msj' => 'Payment Eliminado' , compact('payment')];
    }
}
