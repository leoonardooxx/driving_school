<?php

namespace App\Http\Requests\Vehicle;

use Illuminate\Foundation\Http\FormRequest;

class StoreVehicleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'brand' => ['required'],
            'model' => ['required'],
            'license_plate' => ['required', 'unique:vehicles,license_plate'],
            'transmission_type' => ['required', 'in:MANUAL,AUTOMATIC'],
            'fuel_type' => ['required', 'in:PETROL,DIESEL,ELECTRIC,HYBRID,LPG'],
            'photo' => ['required'],
        ];
    }
}
