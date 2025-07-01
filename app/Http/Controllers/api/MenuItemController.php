<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use Illuminate\Http\Request;

class MenuItemController extends Controller
{
    function allMenuItems()
    {
        $menus = MenuItem::with('menuCategory')->get();
        if ($menus->isEmpty()) {
            return response()->json(['message' => 'No menu items found'], 404);
        }
        return response()->json([
            'message' => 'All menu items retrieved successfully',

            'data' => $menus
        ]);
    } //end method


    function singleMenuItem($id)
    {
        $menu = MenuItem::find($id);
        if ($menu) {
            return response()->json([
                'message' => "Menu item with ID $id retrieved successfully",
                'data' => $menu
            ]);
        } else {
            return response()->json(['message' => "Menu item with ID $id not found"], 404);
        }
    } //end method



    public function createMenuItem(Request $request)
    {

        $validator = validator($request->all(), [
            'name' => 'required|string|max:255|unique:menu_items,name',
            'price' => 'required|numeric|min:0',
            'menu_category_id' => 'required|exists:menu_categories,id',
            'description' => 'nullable|string|max:1000',
            'image' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048', // optional validation
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        // Logic to create a new menu item

        $menuItem = new MenuItem();
        $menuItem->name = $request->name;
        $menuItem->price = $request->price;
        $menuItem->menu_category_id = $request->menu_category_id;
        $menuItem->description = $request->description;

        if ($request->hasFile('image')) {

            $imagePath = $request->file('image')->store('menu_item_images', 'public');
            $menuItem->image = $imagePath;
        } else {
            $menuItem->image = null; // Or set a default image path
        }

        $menuItem->save();

        return response()->json([
            'message' => 'Menu item created successfully',
            'data' => $menuItem
        ], 201);
    } // end method



    function updateMenuItem(Request $request, $id)

    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'menu_category_id' => 'required',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048', // optional validation
        ]);

        $menuItem = MenuItem::find($id);
        if (!$menuItem) {
            return response()->json(['message' => "Menu item with ID $id not found"], 404);
        }

        $menuItem->name = $request->name;
        $menuItem->price = $request->price;
        $menuItem->menu_category_id = $request->menu_category_id;
        $menuItem->description = $request->description;

        if ($request->hasFile('image')) {

            $imagePath = $request->file('image')->store('menu_images', 'public');
            $menuItem->image = $imagePath;
        } else {
            $menuItem->image = null; // Or set a default image path
        }
        // dd($menuItem->image);

        $menuItem->save();

        return response()->json([
            'message' => 'Menu item updated successfully',
            'data' => $menuItem
        ], 201);
    } // end method



    function deleteMenuItem($id)
    {
        // Logic to delete a menu item by ID
        $menuItem = MenuItem::find($id);
        if (!$menuItem) {
            return response()->json(['message' => "Menu item with ID $id not found"], 404);
        }
        $menuItem->delete();

        return response()->json(['message' => "Menu item with ID $id deleted successfully"]);
    }
}// end method
