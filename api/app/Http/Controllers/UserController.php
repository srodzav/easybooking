<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'phone' => 'nullable|string|max:20',
            'role' => 'nullable|integer|in:0,1',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'role' => $request->role ?? 0,
        ]);

        return response()->json([
            'message' => 'User created successfully',
            'user' => $user
        ], 201);
    }

    public function show(User $user)
    {
        return response()->json($user);
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'sometimes|string|min:8',
            'phone' => 'nullable|string|max:20',
            'role' => 'nullable|integer|in:0,1',
        ]);

        if ($request->has('password')) {
            $request->merge([
                'password' => Hash::make($request->password)
            ]);
        }

        $user->update($request->all());

        return response()->json([
            'message' => 'User updated successfully',
            'user' => $user
        ]);
    }

    public function destroy(User $user)
    {
        $user->delete();

        return response()->json([
            'message' => 'User deleted successfully'
        ]);
    }

    /**
     * Estadísticas del dashboard para administradores
     */
    public function dashboardStats()
    {
        $stats = [
            'total_users' => \App\Models\User::count(),
            'total_admins' => \App\Models\User::where('role', 1)->count(),
            'total_clients' => \App\Models\User::where('role', 0)->count(),
            'total_services' => \App\Models\Service::count(),
            'total_reservations' => \App\Models\Reservation::count(),
            'pending_reservations' => \App\Models\Reservation::where('status', 'pending')->count(),
            'confirmed_reservations' => \App\Models\Reservation::where('status', 'confirmed')->count(),
            'total_reviews' => \App\Models\Review::count(),
            'average_rating' => \App\Models\Review::avg('rating'),
            'recent_reservations' => \App\Models\Reservation::with(['user', 'service'])
                ->latest()
                ->limit(5)
                ->get(),
            'recent_reviews' => \App\Models\Review::with(['user', 'service'])
                ->latest()
                ->limit(5)
                ->get(),
        ];

        return response()->json($stats);
    }
}