<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ListingRequest extends FormRequest
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
            'name' => 'required',
            'address' => 'required',
            'website' => 'required',
            'email' => 'required|email',
            'phone' => 'required|numeric',
            'bio' => 'required',
        ];
    }

    public function messages()
    {
        return [
            //
        ];
    }
}
