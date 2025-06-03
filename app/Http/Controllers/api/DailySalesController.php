<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DailySalesController extends Controller
{
    public function allDailySales()
    {
       $dailySales = []; // Logic to retrieve all daily sales
        if (empty($dailySales)) {
            return response()->json(['message' => 'No daily sales found'], 404);
        }
        // Assuming $dailySales is an array of daily sales data
        return response()->json([
            'message' => 'All daily sales retrieved successfully',
            'daily_sales' => $dailySales
        ], 200);
        return response()->json(['message' => 'All daily sales retrieved successfully'], 200);
    }

    public function singleDailySale($id)
    {
        // Logic to retrieve a single daily sale by ID
        return response()->json(['message' => "Daily sale with ID $id retrieved successfully"], 200);
    }

    public function createDailySale(Request $request)
    {
        // Validate the request data
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'sale_date' => 'required|date|unique:daily_sales,sale_date',
            'total_sales' => 'required|numeric|min:0',
            'total_orders' => 'required|integer|min:0',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
        }
        // Create a new daily sale
        $dailySale = new \App\Models\DailySale();
        $dailySale->sale_date = $request->sale_date;
        $dailySale->total_sales = $request->total_sales;
        $dailySale->total_orders = $request->total_orders;
        $dailySale->save();
        // Return a success response
        // return response()->json(['message' => 'Daily sale created successfully', 'daily_sale' => $dailySale], 201);
        return response()->json(['message' => 'Daily sale created successfully'], 201);
    }

    public function updateDailySale(Request $request, $id)
    {
        // Logic to update an existing daily sale
        return response()->json(['message' => "Daily sale with ID $id updated successfully"], 200);
    }

    public function deleteDailySale($id)
    {
        // Logic to delete a daily sale by ID
        $dailySale = \App\Models\DailySale::find($id);
        if (!$dailySale) {
            return response()->json(['message' => "Daily sale with ID $id not found"], 404);
        }
        $dailySale->delete();

        return response()->json(['message' => "Daily sale with ID $id deleted successfully"], 200);
    }
    public function dailySalesReport(Request $request)
    {

        $dailySales = \App\Models\DailySale::all();
        // Logic to generate a daily sales report
        $reportData = []; // Assume this is populated with the report data
        if (empty($reportData)) {
            return response()->json(['message' => 'No data available for the daily sales report'], 404);
        }
        // Return the report data
        return response()->json([
            'message' => 'Daily sales report generated successfully',
            'report_data' => $dailySales
        ], 200);

    
    }
    public function dailySalesSummary(Request $request)
    {
        // Logic to generate a daily sales summary
        $dailySales = \App\Models\DailySale::all();
        if ($dailySales->isEmpty()) {
            return response()->json(['message' => 'No daily sales data available'], 404);
        }
        $summary = [
            'total_sales' => $dailySales->sum('total_sales'),
            'total_orders' => $dailySales->sum('total_orders'),
            'average_sales' => $dailySales->avg('total_sales'),
            'average_orders' => $dailySales->avg('total_orders'),
        ];
        // Return the summary data
        return response()->json([
            'message' => 'Daily sales summary generated successfully',
            'summary' => $summary
        ], 200);
    }
    public function dailySalesTrends(Request $request)
    {
        // Logic to analyze daily sales trends
        $dailySales = \App\Models\DailySale::all();
        if ($dailySales->isEmpty()) {
            return response()->json(['message' => 'No daily sales data available'], 404);
        }
        $trends = []; // Assume this is populated with trend analysis data
        // Return the trends data
        if (empty($trends)) {
            return response()->json(['message' => 'No trends data available'], 404);
        }
        $trends = $dailySales->groupBy(function ($sale) {
            return $sale->sale_date->format('Y-m-d'); // Group by date
        })->map(function ($group) {
            return [
                'total_sales' => $group->sum('total_sales'),
                'total_orders' => $group->sum('total_orders'),
            ];
        });
        return response()->json([
            'message' => 'Daily sales trends analyzed successfully',
            'trends' => $trends
        ], 200);
    }
    public function dailySalesByCategory(Request $request)
    {
        // Logic to retrieve daily sales by category
        $dailySales = \App\Models\DailySale::with('category')->get();
        if ($dailySales->isEmpty()) {
            return response()->json(['message' => 'No daily sales data available'], 404);
        }
        $salesByCategory = $dailySales->groupBy('category_id')->map(function ($group) {
            return [
                'total_sales' => $group->sum('total_sales'),
                'total_orders' => $group->sum('total_orders'),
            ];
        });
        if ($salesByCategory->isEmpty()) {
            return response()->json(['message' => 'No sales data by category available'], 404);
        }
        // Return the sales by category data
        return response()->json([
            'message' => 'Daily sales by category retrieved successfully',
            'sales_by_category' => $salesByCategory
        ], 200);
    }
    public function dailySalesByItem(Request $request)
    {
        // Logic to retrieve daily sales by item
        $dailySales = \App\Models\DailySale::with('items')->get();
        if ($dailySales->isEmpty()) {
            return response()->json(['message' => 'No daily sales data available'], 404);
        }
        $salesByItem = $dailySales->flatMap(function ($sale) {
            return $sale->items->map(function ($item) use ($sale) {
                return [
                    'item_id' => $item->id,
                    'item_name' => $item->name,
                    'total_sales' => $item->pivot->quantity * $item->price,
                    'sale_date' => $sale->sale_date,
                ];
            });
        })->groupBy('item_id')->map(function ($group) {
            return [
                'total_sales' => $group->sum('total_sales'),
                'total_orders' => $group->count(),
            ];
        });
        if ($salesByItem->isEmpty()) {
            return response()->json(['message' => 'No sales data by item available'], 404);
        }
        // Return the sales by item data
        return response()->json([
            'message' => 'Daily sales by item retrieved successfully',
            'sales_by_item' => $salesByItem
        ], 200);
    }

    public function dailySalesByPaymentMethod(Request $request)
    {
        // Logic to retrieve daily sales by payment method
        $dailySales = \App\Models\DailySale::with('payments')->get();
        if ($dailySales->isEmpty()) {
            return response()->json(['message' => 'No daily sales data available'], 404);
        }
        $salesByPaymentMethod = $dailySales->flatMap(function ($sale) {
            return $sale->payments->map(function ($payment) use ($sale) {
                return [
                    'payment_method' => $payment->method,
                    'total_sales' => $payment->amount,
                    'sale_date' => $sale->sale_date,
                ];
            });
        })->groupBy('payment_method')->map(function ($group) {
            return [
                'total_sales' => $group->sum('total_sales'),
                'total_orders' => $group->count(),
            ];
        });
        if ($salesByPaymentMethod->isEmpty()) {
            return response()->json(['message' => 'No sales data by payment method available'], 404);
        }
        // Return the sales by payment method data
        return response()->json([
            'message' => 'Daily sales by payment method retrieved successfully',
            'sales_by_payment_method' => $salesByPaymentMethod
        ], 200);
    }


}
