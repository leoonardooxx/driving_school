<?php

namespace App\Http\Controllers\Api;


use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController
{
    /**
     *  Mostra todos os veículos
     */
    public function index()
    {
        $vehicles = Vehicle::all();

        if (!$vehicles) {
            return response()->json([
                'error' => 404,
                'message' => 'Vehicles not found.'
            ], 404);
        }
        
        return $vehicles;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Vehicle $vehicle)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vehicle $vehicle)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Vehicle $vehicle)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vehicle $vehicle)
    {
        //
    }
}
