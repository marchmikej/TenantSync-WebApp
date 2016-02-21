<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateTransactionRequest extends Request
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
            'payable_id' => 'required|numeric',
            'payable_type' => 'required',
            //'date' => 'required|date|before:today',
            'date' => 'required',
            'amount' => 'required|numeric',
            'description' => 'required',
        ];
    }
}
