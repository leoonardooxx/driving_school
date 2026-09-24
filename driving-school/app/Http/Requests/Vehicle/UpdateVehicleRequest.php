<?php

namespace App\Http\Requests\Vehicle;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVehicleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'brand' => ['sometimes', 'string'],
            'model' => ['sometimes', 'string'],
            'license_plate' => ['sometimes', 'unique:vehicles,license_plate,' . $this->vehicle->id],
            'transmission_type' => ['sometimes', 'in:MANUAL,AUTOMATIC'],
            'fuel_type' => ['sometimes', 'in:PETROL,DIESEL,ELECTRIC,HYBRID,LPG'],
            'photo' => ['sometimes', 'string'],
        ];
    }
}
