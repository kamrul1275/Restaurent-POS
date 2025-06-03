<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function allExpenses()
    {
        $expenses = Expense::all();
        if ($expenses->isEmpty()) {
            return response()->json(['message' => 'No expenses found'], 404);
        }
        // Logic to retrieve all expenses
        return response()->json([
            'message' => 'All expenses retrieved successfully',
            'expenses' => $expenses
        ], 200);
        return response()->json(['message' => 'All expenses retrieved successfully'], 200);
    }//end method



    public function singleExpense($id)
    {
       $expenses = Expense::find($id);
        if (!$expenses) {
            return response()->json(['message' => "Expense with ID $id not found"], 404);
        }
        // Logic to retrieve a single expense by ID
        return response()->json([
            'message' => "Expense with ID $id retrieved successfully",
            'expense' => $expenses
        ], 200);
    }

    public function createExpense(Request $request)
    {
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'reason' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'date' => 'nullable|date',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
        }
        
        $expense = new Expense();
        $expense->reason = $request->reason;
        $expense->amount = $request->amount;
        $expense->date = $request->date ? $request->date : now();
        //dd($expense);
        $expense->save();

        return response()->json(['message' => 'Expense created successfully', 'expense' => $expense], 201);
    }//end method



    public function updateExpense(Request $request, $id)
    {
        $expense = Expense::find($id);
        if (!$expense) {
            return response()->json(['message' => "Expense with ID $id not found"], 404);
        }
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'reason' => 'sometimes|required|string|max:255',
            'amount' => 'sometimes|required|numeric|min:0',
            'date' => 'sometimes|nullable|date',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
        }
        if ($request->has('reason')) {
            $expense->reason = $request->reason;
        }
        if ($request->has('amount')) {
            $expense->amount = $request->amount;
        }
        if ($request->has('date')) {
            $expense->date = $request->date;
        } else {
            $expense->date = now(); // Set to current date if not provided
        }
        $expense->save();
        return response()->json(['message' => "Expense with ID $id updated successfully"], 200);
    }//end method




    public function deleteExpense($id)
    {
       $expense = Expense::find($id);
        if (!$expense) {
            return response()->json(['message' => "Expense with ID $id not found"], 404);
        }
        $expense->delete();
        // Logic to delete an existing expense by ID
        // Assuming the deletion was successful
        return response()->json(['message' => "Expense with ID $id deleted successfully"], 200);
    }//end method



    public function totalExpenses()
    {
        $totalExpenses = Expense::sum('amount');
        if ($totalExpenses === 0) {
            return response()->json(['message' => 'No expenses found'], 404);
        }
        // Logic to calculate total expenses
        return response()->json([
            'message' => 'Total expenses calculated successfully',
            'total_expenses' => $totalExpenses
        ], 200);

    }// end method



    public function expensesByDate($date)
    {
        $expenses = Expense::whereDate('date', $date)->get();
        if ($expenses->isEmpty()) {
            return response()->json(['message' => "No expenses found for date $date"], 404);
        }
        // Logic to retrieve expenses by date
        return response()->json([
            'message' => "Expenses for date $date retrieved successfully",
            'expenses' => $expenses
        ], 200);
    }
}
