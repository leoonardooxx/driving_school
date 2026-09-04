<?php

namespace App\Http\Controllers\Api;


use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController
{
    /**
     * Mostra todos os pagamentos
     */
    public function index()
    {
        $payments = Payment::all();

        if (!$payments) {
            return response()->json([
                'error' => 404,
                'message' => 'Payments not found.'
            ], 404);
        }
        
        return $payments;
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        //
    }
}
