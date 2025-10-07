<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        
        if ($user) {
            // Si es admin, ve todas las reseñas
            if ($user->isAdmin()) {
                $reviews = Review::with(['user', 'service', 'reservation'])->get();
            } else {
                // Si es cliente, solo ve sus reseñas
                $reviews = Review::with(['user', 'service', 'reservation'])
                    ->where('user_id', $user->id)
                    ->get();
            }
        } else {
            // Acceso público - todas las reseñas
            $reviews = Review::with(['user', 'service', 'reservation'])->get();
        }
        
        return response()->json($reviews);
    }

    public function store(Request $request)
    {
        $user = $request->user();
        
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'reservation_id' => 'required|exists:reservations,id|unique:reviews,reservation_id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        // Verificar que la reserva pertenece al usuario (para clientes)
        if ($user->isClient()) {
            $reservation = \App\Models\Reservation::find($request->reservation_id);
            if ($reservation->user_id !== $user->id) {
                return response()->json([
                    'message' => 'No puedes crear una reseña para una reserva que no te pertenece.'
                ], 403);
            }
            
            $reviewData = $request->all();
            $reviewData['user_id'] = $user->id;
        } else {
            // Admins pueden especificar user_id
            $request->validate([
                'user_id' => 'required|exists:users,id',
            ]);
            $reviewData = $request->all();
        }

        $review = Review::create($reviewData);

        return response()->json([
            'message' => 'Review created successfully',
            'review' => $review
        ], 201);
    }

    public function show(Request $request, Review $review)
    {
        $user = $request->user();
        
        // Los clientes solo pueden ver sus propias reseñas (cuando están autenticados)
        if ($user && $user->isClient() && $review->user_id !== $user->id) {
            return response()->json([
                'message' => 'No tienes permisos para ver esta reseña.'
            ], 403);
        }
        
        return response()->json($review->load(['user', 'service', 'reservation']));
    }

    public function update(Request $request, Review $review)
    {
        $user = $request->user();
        
        // Los clientes solo pueden modificar sus propias reseñas
        if ($user->isClient() && $review->user_id !== $user->id) {
            return response()->json([
                'message' => 'No tienes permisos para modificar esta reseña.'
            ], 403);
        }
        
        if ($user->isClient()) {
            // Los clientes solo pueden modificar rating y comment
            $request->validate([
                'rating' => 'sometimes|integer|min:1|max:5',
                'comment' => 'nullable|string',
            ]);
        } else {
            // Los admins pueden modificar todo
            $request->validate([
                'user_id' => 'sometimes|exists:users,id',
                'service_id' => 'sometimes|exists:services,id',
                'reservation_id' => 'sometimes|exists:reservations,id|unique:reviews,reservation_id,' . $review->id,
                'rating' => 'sometimes|integer|min:1|max:5',
                'comment' => 'nullable|string',
            ]);
        }

        $review->update($request->all());

        return response()->json([
            'message' => 'Review updated successfully',
            'review' => $review
        ]);
    }

    public function destroy(Request $request, Review $review)
    {
        $user = $request->user();
        
        // Los clientes solo pueden eliminar sus propias reseñas
        if ($user->isClient() && $review->user_id !== $user->id) {
            return response()->json([
                'message' => 'No tienes permisos para eliminar esta reseña.'
            ], 403);
        }
        
        $review->delete();

        return response()->json([
            'message' => 'Review deleted successfully'
        ]);
    }
}