<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function allPayments()
    {
        $payments = Payment::with('order')->get();
        if ($payments->isEmpty()) {
            return response()->json(['message' => 'No payments found'], 404);
        }
        // Logic to retrieve all payments
        return response()->json(['message' => 'All payments retrieved successfully',
            'data' => $payments]);
    }

    // public function singlePayment($id)
    // {
    //     $payment = Payment::find($id);
    //     if (!$payment) {
    //         return response()->json(['message' => 'Payment not found'], 404);
    //     }
    //     // Logic to retrieve a single payment by ID
    //     $payment->load('order'); // Assuming Payment has a relationship with Order

    //     if (!$payment->order) {
    //         return response()->json(['message' => 'Order not found for this payment'], 404);
    //     }
    //     $payment->order->load('items'); // Load related items for the order
    //     if ($payment->order->items->isEmpty()) {
    //         return response()->json(['message' => 'No items found for this order'], 404);
    //     }
    //     $payment->order->items->each(function ($item) {
    //         $item->load('menuItem'); // Assuming OrderItem has a relationship with MenuItem
    //     });
    //     return response()->json(['message' => "Payment with ID $id retrieved successfully"]);
    // }

    public function createPayment(Request $request)
    {

        $payment = new Payment();
        $payment->order_id = $request->order_id;
        $payment->amount = $request->amount;
        $payment->payment_method = $request->payment_method;
        $payment->status = $request->status;
        $payment->paid_at = now();
        // dd($payment);
        $payment->save();

        return response()->json(['message' => 'Payment created successfully'], 201);
    }

    public function updatePayment(Request $request, $id)
    {
        // Logic to update an existing payment by ID
        return response()->json(['message' => "Payment with ID $id updated successfully"]);
    }

    public function deletePayment($id)
    {
        $payment = Payment::find($id);
        if (!$payment) {
            return response()->json(['message' => 'Payment not found'], 404);
        }
        $payment->delete();
        return response()->json(['message' => "Payment with ID $id deleted successfully",
            'data' => $payment]);
    }
    public function paymentHistory($userId)
    {
        // Logic to retrieve payment history for a specific user
        $payments = Payment::where('user_id', $userId)->get();
        if ($payments->isEmpty()) {
            return response()->json(['message' => 'No payment history found for this user'], 404);
        }
        // Assuming Payment has a relationship with Order
        $payments->each(function ($payment) {
            $payment->load('order'); // Load related order for each payment
            if ($payment->order) {
                $payment->order->load('items'); // Load related items for the order
                $payment->order->items->each(function ($item) {
                    $item->load('menuItem'); // Load related menu item for each order item
                });
            }
        });
        // Return the payment history for the user
        return response()->json([
            'message' => "Payment history for user ID $userId retrieved successfully",
            'data' => $payments
        ]);

    }
}
