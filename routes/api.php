<?php

use App\Http\Controllers\api\DailySalesController;
use App\Http\Controllers\api\ExpenseController;
use App\Http\Controllers\api\MenuCategoryController;
use App\Http\Controllers\api\MenuItemController;
use App\Http\Controllers\api\OrderController;
use App\Http\Controllers\api\OrderItemController;
use App\Http\Controllers\api\PaymentController;
use App\Http\Controllers\api\ReservationController;
use App\Http\Controllers\api\TableController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


//menu category
Route::get('/menu_categories', [MenuCategoryController::class, 'allMenuCategory'])->name('menu_categories.all');
Route::get('/menu_categories/{id}', [MenuCategoryController::class, 'singleMenuCategory'])->name('menu_categories.all');
Route::post('/create_menu_categories', [MenuCategoryController::class, 'createMenuCategory'])->name('create_menu_categories');
Route::put('/update_menu_categories/{id}', [MenuCategoryController::class, 'updateMenuCategory'])->name('update_menu_categories');
Route::delete('/delete_menu_categories/{id}', [MenuCategoryController::class, 'deleteMenuCategory'])->name('delete_menu_categories');




//menu items
Route::get('/menu_items', [MenuItemController::class, 'allMenuItems'])->name('all_menu_items');
Route::get('/menu_items/{id}', [MenuItemController::class, 'singleMenuItem'])->name('single_menu_item');
Route::post('/create_menu_items', [MenuItemController::class, 'createMenuItem'])->name('create_menu_item');
Route::post('/update_menu_items/{id}', [MenuItemController::class, 'updateMenuItem'])->name('update_menu_item');
Route::delete('/delete_menu_items/{id}', [MenuItemController::class, 'deleteMenuItem'])->name('delete_menu_item');



// //tables
Route::get('/tables', [TableController::class, 'allTables'])->name('all_tables');
Route::get('/tables/{id}', [TableController::class, 'singleTable'])->name('single_table');
Route::post('/create_tables', [TableController::class, 'createTable'])->name('create_table');
Route::put('/update_tables/{id}', [TableController::class, 'updateTable'])->name('update_table');
Route::delete('/delete_tables/{id}', [TableController::class, 'deleteTable'])->name('delete_table');



// //orders
Route::get('/orders', [OrderController::class, 'allOrders'])->name('all_orders');
Route::get('/orders/{id}', [OrderController::class, 'singleOrder'])->name('single_order');
Route::post('/create_orders', [OrderController::class, 'createOrder'])->name('create_order');
Route::put('/update_orders/{id}', [OrderController::class, 'updateOrder'])->name('update_order');
Route::delete('/delete_orders/{id}', [OrderController::class, 'deleteOrder'])->name('delete_order');




// //order items
Route::get('/order_items', [OrderItemController::class, 'allOrderItems'])->name('all_order_items');
Route::get('/order_items/{id}', [OrderItemController::class, 'singleOrderItem'])->name('single_order_item');
Route::post('/create_order_items', [OrderItemController::class, 'createOrderItem'])->name('create_order_item');
Route::put('/update_order_items/{id}', [OrderItemController::class, 'updateOrderItem'])->name('update_order_item');
Route::delete('/delete_order_items/{id}', [OrderItemController::class, 'deleteOrderItem'])->name('delete_order_item');


//expense
Route::get('/expenses', [ExpenseController::class, 'allExpenses'])->name('all_expenses');
Route::get('/expenses/{id}', [ExpenseController::class, 'singleExpense'])->name('single_expense');
Route::post('/create_expenses', [ExpenseController::class, 'createExpense'])->name('create_expense');
Route::put('/update_expenses/{id}', [ExpenseController::class, 'updateExpense'])->name('update_expense');
Route::delete('/delete_expenses/{id}', [ExpenseController::class, 'deleteExpense'])->name('delete_expense');


// daily sales

Route::get('/daily_sales', [DailySalesController::class, 'allDailySales'])->name('all_daily_sales');
Route::get('/daily_sales/{id}', [DailySalesController::class, 'singleDailySale'])->name('single_daily_sale');
Route::post('/create_daily_sales', [DailySalesController::class, 'createDailySale'])->name('create_daily_sale');
Route::put('/update_daily_sales/{id}', [DailySalesController::class, 'updateDailySale'])->name('update_daily_sale');
Route::delete('/delete_daily_sales/{id}', [DailySalesController::class, 'deleteDailySale'])->name('delete_daily_sale');
// Route::get('/daily_sales/report', [DailySalesController::class, 'dailySalesReport'])->name('generate_daily_sales_report');

// Route::get('/daily_sales/report', [DailySalesController::class, 'dailySalesSummary'])->name('generate_daily_sales_report');
// Route::get('/daily_sales/report', [DailySalesController::class, 'dailySalesTrends'])->name('generate_daily_sales_report');
// Route::get('/daily_sales/report', [DailySalesController::class, 'dailySalesByCategory'])->name('generate_daily_sales_report');
// Route::get('/daily_sales/report', [DailySalesController::class, 'dailySalesByItem'])->name('generate_daily_sales_report');

// Route::get('/daily_sales/report', [DailySalesController::class, 'dailySalesByPaymentMethod'])->name('generate_daily_sales_report');








// reservation 

Route::get('/reservations', [ReservationController::class, 'allReservations'])->name('all_reservations');
Route::get('/reservations/{id}', [ReservationController::class, 'singleReservation'])->name('single_reservation');
Route::post('/create_reservations', [ReservationController::class, 'createReservation'])->name('create_reservation');
Route::put('/update_reservations/{id}', [ReservationController::class, 'updateReservation'])->name('update_reservation');
Route::delete('/delete_reservations/{id}', [ReservationController::class, 'deleteReservation'])->name('delete_reservation');


// payment

Route::get('/payments', [PaymentController::class, 'allPayments'])->name('all_payments');
Route::get('/payments/{id}', [PaymentController::class, 'singlePayment'])->name('single_payment');
Route::post('/create_payments', [PaymentController::class, 'createPayment'])->name('create_payment');
Route::put('/update_payments/{id}', [PaymentController::class, 'updatePayment'])->name('update_payment');
Route::delete('/delete_payments/{id}', [PaymentController::class, 'deletePayment'])->name('delete_payment');
