<?php

namespace App\Http\Controllers;

use App\Models\PaymentTransaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentTransactionController extends Controller
{
    // GET /api/payments - Get user's payment transactions
    public function index()
    {
        $user = User::find(Auth::id());

        if (! $user) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 403);
        }

        $payments = $user->paymentTransactions()
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($payments, 200);
    }

    // GET /api/payments/{id}
    public function show($id)
    {
        $payment = PaymentTransaction::findOrFail($id);

        // pastikan hanya owner yg bisa lihat
        if (Auth::id() !== $payment->user_id) {
            abort(403, 'Unauthorized');
        }

        return response()->json($payment, 200);
    }

    // POST /api/payments
    public function store(Request $request)
    {
        $validated = $request->validate([
            'reference_id' => 'required|string|unique:payment_transactions',
            'amount' => 'required|numeric|min:0.01',
            'payment_method' => 'nullable|string',
            'gateway' => 'nullable|string',
            'metadata' => 'nullable|json',
        ]);

        $payment = PaymentTransaction::create([
            'user_id' => Auth::id(),
            'reference_id' => $validated['reference_id'],
            'amount' => $validated['amount'],
            'status' => 'pending',
            'payment_method' => $validated['payment_method'] ?? null,
            'gateway' => $validated['gateway'] ?? null,
            'metadata' => $validated['metadata'] ?? null,
        ]);

        return response()->json($payment, 201);
    }

    // PUT /api/payments/{id}
    public function update(Request $request, $id)
    {
        $payment = PaymentTransaction::findOrFail($id);

        // pastikan hanya owner yg bisa update
        if (Auth::id() !== $payment->user_id) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'status' => 'required|in:pending,processing,success,failed,cancelled,refunded',
            'gateway_transaction_id' => 'nullable|string',
            'transaction_date' => 'nullable|date',
            'metadata' => 'nullable|json',
        ]);

        $payment->update($validated);

        return response()->json($payment, 200);
    }

    // GET /api/payments/by-reference/{referenceId}
    public function getByReference($referenceId)
    {
        $payment = PaymentTransaction::where(
            'reference_id',
            $referenceId
        )->first();

        if (! $payment) {
            return response()->json([
                'message' => 'Payment not found',
            ], 404);
        }

        // pastikan hanya owner yg bisa lihat
        if (Auth::id() !== $payment->user_id) {
            abort(403, 'Unauthorized');
        }

        return response()->json($payment, 200);
    }
}
