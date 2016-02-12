<?php namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AffiliateRequest extends FormRequest {

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
            //'first' => 'required|min:3',
            //'email' => 'required|email',
            //'last' => 'required|min:3',
            //'phone' => 'required'

        ];
	}

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

}
