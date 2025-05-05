<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with(['user', 'service', 'reservation'])->get();
        return response()->json($reviews);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'service_id' => 'required|exists:services,id',
            'reservation_id' => 'required|exists:reservations,id|unique:reviews,reservation_id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        $review = Review::create($request->all());

        return response()->json([
            'message' => 'Review created successfully',
            'review' => $review
        ], 201);
    }

    public function show(Review $review)
    {
        return response()->json($review->load(['user', 'service', 'reservation']));
    }

    public function update(Request $request, Review $review)
    {
        $request->validate([
            'user_id' => 'sometimes|exists:users,id',
            'service_id' => 'sometimes|exists:services,id',
            'reservation_id' => 'sometimes|exists:reservations,id|unique:reviews,reservation_id,' . $review->id,
            'rating' => 'sometimes|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        $review->update($request->all());

        return response()->json([
            'message' => 'Review updated successfully',
            'review' => $review
        ]);
    }

    public function destroy(Review $review)
    {
        $review->delete();

        return response()->json([
            'message' => 'Review deleted successfully'
        ]);
    }
}