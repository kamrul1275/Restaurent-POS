<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function reportOverview()
    {

        $tota_sales = Order::sum('total_amount');
        $tota_orders = Order::count();
        $averageOrder = $tota_orders > 0 ? $tota_sales / $tota_orders : 0;
        $topItem = OrderItem::select('name', DB::raw('SUM(quantity) as total_qty'))
            ->groupBy('name')
            ->orderByDesc('total_qty')
            ->first();

        return response()->json([
            'totalSales' => $tota_sales,
            'totalOrder' => $tota_orders,
            'averageOrder' =>  $averageOrder,
            'topItem' => $topItem

        ]);
    }// end reportOverview


    public function todaySales(){

        $today = Carbon::today();
        $todaySales = Order::whereDate('order_date', $today)->sum('total_amount');
        $todayOrders = Order::whereDate('order_date', $today)->count();

        $topTodayItem = OrderItem::whereHas('order', function ($q) use ($today) {
                            $q->whereDate('order_date', $today);
                        })
                        ->select('name', DB::raw('SUM(quantity) as total_qty'))
                        ->groupBy('name')
                        ->orderByDesc('total_qty')
                        ->first();

    return response()->json([
        'today_sales'    => round($todaySales, 2),
        'today_orders'   => $todayOrders,
        'top_item'       => $topTodayItem ? $topTodayItem->name : null,
        'top_item_qty'   => $topTodayItem ? $topTodayItem->total_qty : 0
    ]);

    }// end today sales



public function monthlySalesLast12Months(Request $request)
{
    $month = $request->query('month'); // optional month filter
    // dd($month);

    $query = Order::selectRaw("TO_CHAR(order_date, 'YYYY-MM') as month, SUM(total_amount) as total_sales, COUNT(*) as total_orders")
                ->groupBy('month')
                ->orderBy('month');

    if ($month) {
        $query->whereRaw("TO_CHAR(order_date, 'YYYY-MM') = ?", [$month]);
    } else {
        // last 12 months by default
        $startDate = Carbon::now()->subMonths(11)->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();
        $query->whereBetween('order_date', [$startDate, $endDate]);
    }

    $monthlySales = $query->get();

    return response()->json([
        'filter_month'   => $month,
        'monthly_sales'  => $monthlySales
    ]);
}




}
