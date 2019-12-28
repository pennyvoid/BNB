<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Booking;
use App\Http\Resources\BookingByReviewKeyResource;

class BookingByReviewKeyController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke($reviewKey)
    {

        $booking = Booking::findByReviewKey($reviewKey);
        return  $booking ? new BookingByReviewKeyResource($booking) : abort(404);
    }
}
