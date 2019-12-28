<?php

namespace App\Http\Controllers\Api;

use App\Booking;
use App\Http\Controllers\Controller;
use App\Http\Resources\ReviewResource;
use App\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function show($id)
    {
        $review = Review::findOrFail($id);
        return new ReviewResource($review);
    }
    public function store()
    {
        $data = request()->validate([
            'id' => 'required|unique:reviews',
            'content' => 'required',
            'rating' => 'required|in:0,1,2,3,4,5'
        ]);

        $booking = Booking::findByReviewKey($data['id']);

        if ($booking === null) {
            return abort(404);
        }

        $booking->review_key = $data['id'];
        $booking->save();

        $review = Review::make($data);
        $review->booking_id = $booking->id;
        $review->bookable_id = $booking->bookable_id;
        $review->save();
        return new ReviewResource($review);
    }
}
