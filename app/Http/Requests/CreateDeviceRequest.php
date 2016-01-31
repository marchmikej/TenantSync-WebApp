<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateDeviceRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'property_id' => 'required',
            //'financed' => 'required',
            'serial' => 'required',
            'location' => 'required',
            'rent_amount' => 'required',
            //'rent_due' => 'required',
            'late_fee' => 'required',
            'grace_period' => 'required',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zip' => 'required'
        ];
    }
}
