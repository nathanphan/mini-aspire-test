<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoanApplicationRequest extends FormRequest
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
            'email' => 'required|email',
            'term' => 'required|numeric|min:1',
            'amount' => 'required|numeric|min:100', // Assume that minimum loan amount must equal or greater than 100 dollars
            'dob' => 'nullable|date:Y-m-d'
        ];
    }
}
