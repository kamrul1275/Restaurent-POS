<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderItemController extends Controller
{
    public function allOrderItems()
    {
        $orderItems = OrderItem::with('menuItem.menuCategory','order.tables','order.user')->get();
        if ($orderItems->isEmpty()) {
            return response()->json(['message' => 'No order items found'], 404);
        }
        // Logic to retrieve all order items
        // return response()->json([], 200);
        return response()->json([
            'message' => 'All order items retrieved successfully',
            'order_items' => $orderItems
        ], 200);
    }

    public function singleOrderItem($id)
    {
        $orderItem = OrderItem::find($id);
        if (!$orderItem) {
            return response()->json(['message' => "Order item with ID $id not found"], 404);
        }
        return response()->json(['message' => "Order item with ID $id retrieved successfully",
            'order_item' => $orderItem
        ], 200);
    }

    public function createOrderItem(Request $request)
    {
        // $orderItemData = $request->validate([
        //     'order_id' => 'required|integer',
        //     'menu_item_id' => 'required|integer',
        //     'quantity' => 'required|integer|min:1',
        //     'price' => 'required|numeric|min:0',
        // ]);
           $validator =Validator::make($request->all(), [
            'order_id' => 'required|integer',
            'menu_item_id' => 'required|integer',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
        }

        $orderItem = new OrderItem();
        $orderItem->order_id = $request->order_id;
        $orderItem->menu_item_id = $request->menu_item_id;
        $orderItem->quantity = $request->quantity;
        $orderItem->price = $request->price;
        $orderItem->save();

        return response()->json([
            'message' => 'Order item created successfully',
            'order_item' => $orderItem
        ], 201);
    }

    public function updateOrderItem(Request $request, $id)
    {
        $orderItemData = $request->validate([
            'order_id' => 'required|integer',
            'menu_item_id' => 'required|integer',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        $orderItem =  OrderItem::find($id);
        if (!$orderItem) {
            return response()->json(['message' => "Order item with ID $id not found"], 404);
        }
        $orderItem->order_id = $orderItemData['order_id'];
        $orderItem->menu_item_id = $orderItemData['menu_item_id'];
        $orderItem->quantity = $orderItemData['quantity'];
        $orderItem->price = $orderItemData['price'];
        $orderItem->save();

        return response()->json([
            'message' => 'Order item update successfully',
            'order_item' => $orderItem
        ], 201);
    }

    public function deleteOrderItem($id)
    {
        $orderItem = OrderItem::find($id);
        if (!$orderItem) {
            return response()->json(['message' => "Order item with ID $id not found"], 404);
        }
        $orderItem->delete();
        return response()->json(['message' => "Order item with ID $id deleted successfully"]);
    }
}
