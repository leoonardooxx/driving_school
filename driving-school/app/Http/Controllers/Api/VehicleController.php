<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Vehicle\StoreVehicleRequest;
use App\Http\Requests\Vehicle\UpdateVehicleRequest;
use App\Models\Vehicle;

class VehicleController
{
    /**
     * Todos os veículos
     */
    public function index()
    {
        $vehicles = Vehicle::all();

        if ($vehicles->isEmpty()) {
            return response()->json([
                'error' => 404,
                'message' => 'Vehicles not found.'
            ], 404);
        }

        return response()->json($vehicles);
    }

    /**
     * Cria um veículo
     */
    public function store(StoreVehicleRequest $request)
    {
        $vehicle = Vehicle::create($request->validated());

        return response()->json($vehicle, 201);
    }

    /**
     * Detalhes de um veículo
     */
    public function show(int $vehicle)
    {
        $vehicle = Vehicle::find($vehicle);

        if (!$vehicle) {
            return response()->json([
                'error' => 404,
                'message' => 'Vehicle not found.'
            ], 404);
        }

        return response()->json($vehicle);
    }

    /**
     * Atualiza um veículo
     */
    public function update(UpdateVehicleRequest $request, Vehicle $vehicle)
    {
        $vehicle->update($request->validated());

        return response()->json($vehicle);
    }

    /**
     * Elimina um veículo
     */
    public function destroy(Vehicle $vehicle)
    {
        if (!$vehicle) {
            return response()->json([
                'error' => 404,
                'message' => 'Vehicle not found.'
            ], 404);
        }

        $isActive = $vehicle->active;

        $vehicle->updateOrFail(['active' => !$isActive]);

        return response()->json($vehicle);
    }
}
