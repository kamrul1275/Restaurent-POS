<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function allOrders()
    {
      $orders = Order::with('tables','user')->get(); // Assuming you have an Order model set up

      //dd($orders);
    if ($orders->isEmpty()) {
        return response()->json(['message' => 'No orders found'], 404);
    }else {
        return response()->json([
            'message' => 'All orders retrieved successfully',
            'data' => $orders
        ]);
    }
    }

    public function singleOrder($id)
    {
        $order = Order::find($id);
        if (!$order) {
            return response()->json(['message' => "Order with ID $id not found"], 404);
        }
        // Logic to retrieve a single order by ID
        return response()->json([
            'message' => "Order with ID $id retrieved successfully",
            'data' => $order]);
    }




public function createOrder(Request $request)
{
    $validator = Validator::make($request->all(), [
        'customer_name' => 'nullable|string|max:255',
        'customer_phone' => 'nullable|string|max:20',
        'subtotal' => 'required|numeric|min:0',
        'discount_percent' => 'nullable|numeric|min:0|max:100',
        'delivery_charge' => 'nullable|numeric|min:0',
        'payment_method' => 'required|in:Cash,Card,Mobile Banking',
        'order_type' => 'required|in:dine_in,takeaway,delivery',
        'delivery_address' => 'nullable|string',
        'order_status' => 'in:pending,preparing,ready,delivered,cancelled',
        'notes' => 'nullable|string',
        'orderitems' => 'required|array', // array of ordered items
        'orderitems.*.name' => 'required|string',
        'orderitems.*.quantity' => 'required|integer|min:1',
        'orderitems.*.price' => 'required|numeric|min:0',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    $discount = $request->discount_percent ?? 0;
    $delivery = $request->delivery_charge ?? 0;
    $subtotal = $request->subtotal;

    $discountAmount = ($subtotal * $discount) / 100;
    $total = $subtotal - $discountAmount + $delivery;

    // Create Order
    $order = new Order();
    $order->order_number = 'ORD NO-' . time();
    $order->customer_name = $request->customer_name;
    $order->customer_phone = $request->customer_phone;
    $order->subtotal = $subtotal;
    $order->discount_percent = $discount;
    $order->delivery_charge = $delivery;
    $order->total_amount = $total;
    $order->payment_method = $request->payment_method;
    $order->order_type = $request->order_type;
    $order->delivery_address = $request->delivery_address;
    $order->order_status = $request->order_status ?? 'pending';
    $order->notes = $request->notes;
    $order->order_date = now();
    $order->save();

    // Save Items (if you have order_items table)
foreach ($request->orderitems as $item) {
    $order->orderitems()->create([
        'name' => $item['name'],
        'quantity' => $item['quantity'],
        'price' => $item['price'],
    ]);
}

    return response()->json([
        'message' => 'Order created successfully',
        'data' => $order
    ], 201);
}



// generate invice


public function showInvoice($id)
{
    $orders = Order::with('orderitems')->findOrFail($id);

 //dd($orders->toArray());

    return response()->json([
        'message' => "Invoice for Order ID $id retrieved successfully",
        'data' => $orders
    ]);
}






    public function updateOrder(Request $request, $id)
    {
        $order =  Order::find($id);
        if (!$order) {
            return response()->json(['message' => "Order with ID $id not found"], 404);
        }

        $order->customer = $request->customer_name;
        $order->table_id = $request->table_id;
        $order->status = $request->status;
        $order->save();

        return response()->json([
            'message' => 'Order update successfully',
            'data' => $order    
    ], 201);
    }

    public function deleteOrder($id)
    {
        $order = Order::find($id);
        if (!$order) {
            return response()->json(['message' => "Order with ID $id not found"], 404);
        }
        // Logic to delete an order
        $order->delete();
        return response()->json(['message' => "Order with ID $id deleted successfully"]);
    }
}
