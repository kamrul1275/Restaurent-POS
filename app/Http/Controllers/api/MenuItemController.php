<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MenuItemController extends Controller
{
    function allMenuItems()
    {
        // Logic to retrieve all menu items
        return response()->json(['message' => 'All menu items retrieved successfully']);
    }
    function singleMenuItem($id)
    {
        // Logic to retrieve a single menu item by ID
        return response()->json(['message' => "Menu item with ID $id retrieved successfully"]);
    }
    function createMenuItem(Request $request)
    {
        // Logic to create a new menu item
        return response()->json(['message' => 'Menu item created successfully'], 201);
    }
    function updateMenuItem(Request $request, $id)
    {
        // Logic to update an existing menu item by ID
        return response()->json(['message' => "Menu item with ID $id updated successfully"]);
    }
    function deleteMenuItem($id)
    {
        // Logic to delete a menu item by ID
        return response()->json(['message' => "Menu item with ID $id deleted successfully"]);
    }
}
