<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Payment\StorePaymentRequest;
use App\Http\Requests\Payment\UpdatePaymentRequest;
use App\Models\Payment;

class PaymentController
{
    /**
     * Todos os pagamentos
     */
    public function index()
    {
        $payments = Payment::all();

        if ($payments->isEmpty()) {
            return response()->json([
                'error' => 404,
                'message' => 'Payments not found.'
            ], 404);
        }

        return response()->json($payments);
    }

    /**
     * Cria um pagamento
     */
    public function store(StorePaymentRequest $request)
    {
        $payment = Payment::create($request->validated());

        return response()->json($payment, 201);
    }

    /**
     * Detalhes de um pagamento
     */
    public function show(int $payment)
    {
        $payment = Payment::find($payment);

        if (!$payment) {
            return response()->json([
                'error' => 404,
                'message' => 'Payment not found.'
            ], 404);
        }

        return response()->json($payment);
    }

    /**
     * Atualiza um pagamento
     */
    public function update(UpdatePaymentRequest $request, Payment $payment)
    {
        $payment->update($request->validated());

        return response()->json($payment);
    }

    /**
     * Ativa/desativa um pagamento
     */
    public function destroy(Payment $payment)
    {
        $payment->update([
            'active' => !$payment->active
        ]);

        return response()->json([
            'message' => $payment->active
                ? 'Payment activated successfully.'
                : 'Payment deactivated successfully.',
            'data' => $payment
        ]);
    }
}
