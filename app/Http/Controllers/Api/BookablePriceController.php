<?php

namespace App\Http\Controllers\Api;

use App\Bookable;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BookablePriceController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke($id)
    {
        $bookable = Bookable::findOrFail($id);
        $data = request()->validate([
            'from' => 'required|date_format:Y-m-d|after_or_equal:from',
            'to' => 'required|date_format:Y-m-d|after_or_equal:from',
        ]);

        return response()->Json([
            'data' => $bookable->priceFor($data['from'], $data['to'])
        ]);
    }
}
