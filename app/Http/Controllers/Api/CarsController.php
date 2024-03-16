<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CarsResource;
use App\Models\Cars;
use Illuminate\Http\Request;

class CarsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return CarsResource::collection(Cars::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $car = Cars::create($request->all());
        return new CarsResource($car);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $car = Cars::find($id);
        return new CarsResource($car);
    }

    /**
     * Display the specified resource.
     */
    public function getAvail(Request $request)
    {
        return CarsResource::collection(Cars::where('status', '1')->get());
        // $cars = Cars::where('status', '1')->get();
        // print_r($cars);die;
        // return CarsResource::collection($cars);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $cars = Cars::find($id);
        $cars->update($request->all());
        return new CarsResource($cars);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cars $cars)
    {
        $cars->delete();

        return response()->noContent();
    }
}
