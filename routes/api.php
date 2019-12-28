<?php

use App\Bookable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/bookables', function () {
    return Bookable::all();
});

Route::get('/bookables/{id}', function ($bookableId) {
    return Bookable::findOrFail($bookableId);
});

Route::apiResource('bookables', 'Api\BookableController')->only(['index', 'show']);
Route::get('/bookables/{bookable}/availability', 'Api\BookableAvailabilityController')->name('bookables.availabiliy.show');
Route::get('/bookables/{bookable}/review', 'Api\BookableReviewController')->name('bookables.review.show');
Route::get('/booking-by-review-key/{reviewKey}', 'Api\BookingByReviewKeyController')->name('booking.by.review');
Route::get('/bookables/{bookable}/price', 'Api\BookablePriceController')->name('bookable.price');
Route::apiResource('reviews', 'Api\ReviewController')->only(['show', 'store']);
    