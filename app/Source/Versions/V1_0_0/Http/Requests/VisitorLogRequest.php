<?php

namespace Api\V1_0_0\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VisitorLogRequest extends FormRequest
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
			"date" => "required",
			"time" => "required",
			"contact_number" => "required",
			"person_to_visit" => "required",
			"email" => "required",
		];
	}
}
