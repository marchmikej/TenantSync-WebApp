<?php 

namespace App\Http\Requests;

use App\Http\Requests\Request;

class LandlordRequest extends Request {

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
			// 'username' => 'required|unique:user',
			'email' => 'required|email|max:255|unique:users',
			'password' => 'required|confirmed',
			'first_name' => 'required',
			'last_name' => 'required',
			'company' => 'required',
			'phone' => 'required',
			// 'card_number' => 'required|max:16|min:16',
			// 'cardholder' => 'required',
			// 'expiration_date' => 'required',
			// 'cvv2' => 'required|max:3|min:3',
			'address' => 'required',
			'city' => 'required',
			'state' => 'required',
			'zip' => 'required',
			'key' => 'required',
			'pin' => 'required'
		];
	}

}
