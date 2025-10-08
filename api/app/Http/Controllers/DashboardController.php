<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Service;
use App\Models\Reservation;
use App\Models\Review;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Obtiene las estadísticas generales del dashboard
     */
    public function getStats(Request $request): JsonResponse
    {
        try {
            // Filtros de fecha opcionales
            $startDate = $request->query('start_date');
            $endDate = $request->query('end_date');

            // Query base para reservaciones con filtros de fecha
            $reservationQuery = Reservation::query();
            if ($startDate && $endDate) {
                $reservationQuery->whereBetween('created_at', [$startDate, $endDate]);
            }

            // Query base para reseñas con filtros de fecha
            $reviewQuery = Review::query();
            if ($startDate && $endDate) {
                $reviewQuery->whereBetween('created_at', [$startDate, $endDate]);
            }

            // Estadísticas básicas
            $totalUsers = User::count();
            $totalServices = Service::count();
            $totalReservations = $reservationQuery->count();
            $totalReviews = $reviewQuery->count();

            // Estados de reservaciones
            $reservationStatuses = $reservationQuery->select('status', DB::raw('count(*) as count'))
                ->groupBy('status')
                ->pluck('count', 'status')
                ->toArray();

            $pendingReservations = $reservationStatuses['pending'] ?? 0;
            $confirmedReservations = $reservationStatuses['confirmed'] ?? 0;
            $cancelledReservations = $reservationStatuses['cancelled'] ?? 0;
            $completedReservations = $reservationStatuses['completed'] ?? 0;

            // Calificación promedio
            $averageRating = $reviewQuery->avg('rating') ?? 0;

            // Reservaciones recientes (últimas 5)
            $recentReservations = Reservation::with(['user:id,name,email', 'service:id,name'])
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get()
                ->map(function ($reservation) {
                    return [
                        'id' => $reservation->id,
                        'user_name' => $reservation->user->name ?? 'Usuario eliminado',
                        'service_name' => $reservation->service->name ?? 'Servicio eliminado',
                        'status' => $reservation->status,
                        'reservation_date' => $reservation->reservation_date,
                        'created_at' => $reservation->created_at->format('Y-m-d H:i:s')
                    ];
                });

            // Reseñas recientes (últimas 5)
            $recentReviews = Review::with(['user:id,name', 'service:id,name'])
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get()
                ->map(function ($review) {
                    return [
                        'id' => $review->id,
                        'user_name' => $review->user->name ?? 'Usuario eliminado',
                        'service_name' => $review->service->name ?? 'Servicio eliminado',
                        'rating' => $review->rating,
                        'comment' => $review->comment,
                        'created_at' => $review->created_at->format('Y-m-d H:i:s')
                    ];
                });

            $stats = [
                'total_users' => $totalUsers,
                'total_services' => $totalServices,
                'total_reservations' => $totalReservations,
                'total_reviews' => $totalReviews,
                'pending_reservations' => $pendingReservations,
                'confirmed_reservations' => $confirmedReservations,
                'cancelled_reservations' => $cancelledReservations,
                'completed_reservations' => $completedReservations,
                'average_rating' => round($averageRating, 1),
                'recent_reservations' => $recentReservations,
                'recent_reviews' => $recentReviews
            ];

            return response()->json($stats);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al obtener estadísticas',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtiene reservaciones recientes
     */
    public function getRecentReservations(Request $request): JsonResponse
    {
        try {
            $limit = $request->query('limit', 10);
            
            $reservations = Reservation::with(['user:id,name,email', 'service:id,name'])
                ->orderBy('created_at', 'desc')
                ->limit($limit)
                ->get()
                ->map(function ($reservation) {
                    return [
                        'id' => $reservation->id,
                        'user_name' => $reservation->user->name ?? 'Usuario eliminado',
                        'user_email' => $reservation->user->email ?? '',
                        'service_name' => $reservation->service->name ?? 'Servicio eliminado',
                        'status' => $reservation->status,
                        'reservation_date' => $reservation->reservation_date,
                        'notes' => $reservation->notes,
                        'created_at' => $reservation->created_at->format('Y-m-d H:i:s')
                    ];
                });

            return response()->json($reservations);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al obtener reservaciones recientes',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtiene reseñas recientes
     */
    public function getRecentReviews(Request $request): JsonResponse
    {
        try {
            $limit = $request->query('limit', 10);
            
            $reviews = Review::with(['user:id,name', 'service:id,name'])
                ->orderBy('created_at', 'desc')
                ->limit($limit)
                ->get()
                ->map(function ($review) {
                    return [
                        'id' => $review->id,
                        'user_name' => $review->user->name ?? 'Usuario eliminado',
                        'service_name' => $review->service->name ?? 'Servicio eliminado',
                        'rating' => $review->rating,
                        'comment' => $review->comment,
                        'created_at' => $review->created_at->format('Y-m-d H:i:s')
                    ];
                });

            return response()->json($reviews);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al obtener reseñas recientes',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}