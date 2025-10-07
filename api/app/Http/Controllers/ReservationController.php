<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        
        // Si es admin, ve todas las reservas
        if ($user->isAdmin()) {
            $reservations = Reservation::with(['user', 'service'])->get();
        } else {
            // Si es cliente, solo ve sus reservas
            $reservations = Reservation::with(['user', 'service'])
                ->where('user_id', $user->id)
                ->get();
        }
        
        return response()->json($reservations);
    }

    public function store(Request $request)
    {
        $user = $request->user();
        
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'notes' => 'nullable|string',
        ]);

        // Para clientes, la reserva se crea automáticamente con su user_id
        $reservationData = $request->all();
        if ($user->isClient()) {
            $reservationData['user_id'] = $user->id;
            $reservationData['status'] = 'pending';
        } else {
            // Solo admins pueden especificar user_id y status
            $request->validate([
                'user_id' => 'required|exists:users,id',
                'status' => 'required|string|in:pending,confirmed,cancelled,completed',
            ]);
        }

        $reservation = Reservation::create($reservationData);

        return response()->json([
            'message' => 'Reservation created successfully',
            'reservation' => $reservation
        ], 201);
    }

    public function show(Request $request, Reservation $reservation)
    {
        $user = $request->user();
        
        // Los clientes solo pueden ver sus propias reservas
        if ($user->isClient() && $reservation->user_id !== $user->id) {
            return response()->json([
                'message' => 'No tienes permisos para ver esta reserva.'
            ], 403);
        }
        
        return response()->json($reservation->load(['user', 'service']));
    }

    public function update(Request $request, Reservation $reservation)
    {
        $user = $request->user();
        
        // Los clientes solo pueden modificar sus propias reservas
        if ($user->isClient() && $reservation->user_id !== $user->id) {
            return response()->json([
                'message' => 'No tienes permisos para modificar esta reserva.'
            ], 403);
        }
        
        if ($user->isClient()) {
            // Los clientes solo pueden modificar ciertos campos
            $request->validate([
                'start_time' => 'sometimes|date',
                'end_time' => 'sometimes|date|after:start_time',
                'notes' => 'nullable|string',
            ]);
        } else {
            // Los admins pueden modificar todo
            $request->validate([
                'user_id' => 'sometimes|exists:users,id',
                'service_id' => 'sometimes|exists:services,id',
                'start_time' => 'sometimes|date',
                'end_time' => 'sometimes|date|after:start_time',
                'status' => 'sometimes|string|in:pending,confirmed,cancelled,completed',
                'notes' => 'nullable|string',
            ]);
        }

        $reservation->update($request->all());

        return response()->json([
            'message' => 'Reservation updated successfully',
            'reservation' => $reservation
        ]);
    }

    public function destroy(Request $request, Reservation $reservation)
    {
        $user = $request->user();
        
        // Los clientes solo pueden cancelar sus propias reservas
        if ($user->isClient() && $reservation->user_id !== $user->id) {
            return response()->json([
                'message' => 'No tienes permisos para cancelar esta reserva.'
            ], 403);
        }
        
        $reservation->delete();

        return response()->json([
            'message' => 'Reservation deleted successfully'
        ]);
    }
}