<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RentalResource;
use App\Models\Cars;
use App\Models\Rental;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RentalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return RentalResource::collection(Rental::all());
    }

    public function getRentalById($id)
    {
        $rental = Rental::join('cars', 'rentals.car_id', '=', 'cars.id')
            ->select([
                'rentals.id',
                'rentals.start_date',
                'rentals.end_date',
                'rentals.return_date',
                'rentals.additional_cost',
                'rentals.price',
                'cars.no_plat',
                'cars.name',
                'cars.model',
                'cars.brand',
                'cars.no_plat'
            ])
            ->where('rentals.user_id', $id)
            ->get();
        return RentalResource::collection($rental);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'car_id' => ['required', 'exists:cars,id'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date']
        ]);
        // Check car is available
        $check = Rental::where('car_id', $request->car_id)
            ->where('start_date', '<=', $request->end_date)
            ->where('end_date', '>=', $request->start_date)
            ->get();
        if ($check->isNotEmpty()) {
            return response()->json(['error' => 'Car is not available'], 400);
        }

        // check price car
        $car = Cars::find($request->car_id);
        //price = price * total days
        $totalDay = Carbon::parse($request->start_date)->diffInDays($request->end_date);
        $totalDay = $totalDay == 0 ? 1 : $totalDay+1;
        $price = $car->price * $totalDay;
        $rental = new Rental();
        $rental->user_id = $request->user_id;
        $rental->car_id = $request->car_id;
        $rental->start_date = $request->start_date;
        $rental->end_date = $request->end_date;
        $rental->price = $price;
        $rental->save();

        $car->status = '0';
        $car->save();

        return new RentalResource($rental);
    }

    /**
     * Display the specified resource.
     */
    public function show(Rental $rental)
    {
        return new RentalResource($rental);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Rental $rental)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rental $rental)
    {
        //
    }

    /**
     * Return a car.
     */
    public function returnCar(Request $request, $id)
    {
        $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'return_date' => ['required', 'date'],
            'no_plat' => ['required', 'exists:cars,no_plat'],
        ]);

        // Check car plat
        $car = Cars::where('no_plat', $request->no_plat)->first();
        if ($car == null) {
            return response()->json(['error' => 'Car not found'], 400);
        }

        $rental = Rental::find($id);

        // Check car
        if ($rental->user_id != $request->user_id) {
            return response()->json(['error' => 'Car is not yours'], 400);
        }

        // Check End Date
        if ($request->return_date > $rental->end_date) {
            // Calculate Additional Cost
            $diff = Carbon::parse($request->return_date)->diffInDays($rental->end_date);
            $additional_cost = $diff * $rental->price;

            // Set Return Date and Add
            $rental->return_date = $request->return_date;
            $rental->additional_cost = $additional_cost;
        } else {
            $rental->return_date = $request->return_date;
            $rental->additional_cost = 0;
        }

        $rental->save();

        $car->status = '1';
        $car->save();
        return new RentalResource($rental);
    }
}
