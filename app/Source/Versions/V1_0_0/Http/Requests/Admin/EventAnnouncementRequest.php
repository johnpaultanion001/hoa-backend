<?php

namespace Api\V1_0_0\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class EventAnnouncementRequest extends FormRequest
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
			"title" => "required",
            "description" => "required",
            "date" => "required",
            "time" => "required",
            "body" => "required"
		];
	}
}
