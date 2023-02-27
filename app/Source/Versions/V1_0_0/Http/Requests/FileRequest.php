<?php

namespace Api\V1_0_0\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FileRequest extends FormRequest
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
			'table_type' => 'required',
			'table_id' => 'nullable',
			'path' => 'required',
			'file_name' => 'required',
			'type' => 'required',
            "full_url" => 'required'
		];
	}
}
