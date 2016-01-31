<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreatePropertyRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Auth::user()->role == 'landlord' ? true : false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zip' => 'required|numeric',
            'purchase_price' => 'required|numeric',
            'purchase_date' => 'required|date',
            'closing_costs' => 'required|numeric',
            'taxes' => 'required|numeric',
            'expenses' => 'required|numeric',
            'insurance' => 'required|numeric',
            'down_payment' => 'required|numeric',
            'mortgage_rate' => 'required|numeric',
            'mortgage_term' => 'required|numeric',
        ];
    }
}
