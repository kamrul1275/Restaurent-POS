<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function allReservations()
    {
        // Logic to retrieve all reservations
        return response()->json(['message' => 'All reservations retrieved successfully']);
    }

    public function singleReservation($id)
    {
        // Logic to retrieve a single reservation by ID
        return response()->json(['message' => "Reservation with ID $id retrieved successfully"]);
    }

    public function createReservation(Request $request)
    {
        // Logic to create a new reservation
        return response()->json(['message' => 'Reservation created successfully'], 201);
    }

    public function updateReservation(Request $request, $id)
    {
        // Logic to update an existing reservation by ID
        return response()->json(['message' => "Reservation with ID $id updated successfully"]);
    }

    public function deleteReservation($id)
    {
        // Logic to delete a reservation by ID
        return response()->json(['message' => "Reservation with ID $id deleted successfully"]);
    }
}
