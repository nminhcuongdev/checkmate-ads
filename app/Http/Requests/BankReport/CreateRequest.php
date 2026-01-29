<?php

namespace App\Http\Requests\BankReport;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'bank_id' => 'required',
            'date' => 'required',
            'receive' => 'required|numeric',
            'transfer' => 'required|numeric',
            'refund' => 'required|numeric',
            'pay' => 'required|numeric'
        ];
    }
}
