<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\MenuCategory;
use Illuminate\Http\Request;

class MenuCategoryController extends Controller
{
    public function allMenuCategory()
    {
        $menuCategories = MenuCategory::all();
        return response()->json($menuCategories);
    }//end method
    public function singleMenuCategory($id)
    {
        $menuCategory = MenuCategory::find($id);
        if ($menuCategory) {
            return response()->json($menuCategory);
        } else {
            return response()->json(['message' => 'Menu Category not found'], 404);
        }
    }//end method
    public function createMenuCategory(Request $request)
    {
        $menuCategory = MenuCategory::create($request->all());
        return response()->json($menuCategory, 201);
    }//end method
    public function updateMenuCategory(Request $request, $id)
    {
        $menuCategory = MenuCategory::find($id);
        if ($menuCategory) {
            $menuCategory->update($request->all());
            return response()->json($menuCategory);
        } else {
            return response()->json(['message' => 'Menu Category not found'], 404);
        }
    }//end method
    public function deleteMenuCategory($id)
    {
        $menuCategory = \App\Models\MenuCategory::find($id);
        if ($menuCategory) {
            $menuCategory->delete();
            return response()->json(['message' => 'Menu Category deleted successfully']);
        } else {
            return response()->json(['message' => 'Menu Category not found'], 404);
        }
    }//end method
}
