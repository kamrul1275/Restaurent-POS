<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    public function allOrderItems()
    {
        // Logic to retrieve all order items
        return response()->json(['message' => 'All order items retrieved successfully']);
    }

    public function singleOrderItem($id)
    {
        // Logic to retrieve a single order item by ID
        return response()->json(['message' => "Order item with ID $id retrieved successfully"]);
    }

    public function createOrderItem(Request $request)
    {
        // Logic to create a new order item
        return response()->json(['message' => 'Order item created successfully'], 201);
    }

    public function updateOrderItem(Request $request, $id)
    {
        // Logic to update an existing order item by ID
        return response()->json(['message' => "Order item with ID $id updated successfully"]);
    }

    public function deleteOrderItem($id)
    {
        // Logic to delete an order item by ID
        return response()->json(['message' => "Order item with ID $id deleted successfully"]);
    }
}
