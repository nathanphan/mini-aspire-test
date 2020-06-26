<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class LoanApplicationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
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
            'dob' => 'nullable|date:Y-m-d',
            'first_name' => 'nullable|string',
            'last_name' => 'nullable|string',
            'monthly_income' => 'numeric',
            'phone' => 'required',
            'note' => 'nullable',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Email is required!',
            'term.required' => 'Term is required!',
            'phone.required' => 'Phone number is required!',
            'amount.required' => 'Amount is required!',
            'amount.min' => 'Amount must be at least 100 USD',
        ];
    }
}
