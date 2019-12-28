<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Bookable;
use App\Http\Resources\BookableResource;

class BookableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $bookables = Bookable::all();
        return BookableResource::collection($bookables);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {
        $bookable = Bookable::findOrFail($id);
        return new BookableResource($bookable);
    }
}
