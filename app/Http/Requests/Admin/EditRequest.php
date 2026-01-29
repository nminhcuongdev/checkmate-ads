<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EditRequest extends FormRequest
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
        $id = $this->route('id');
        return [
            'name' => 'bail|required|max:128',
            'email' => 'bail|required|email|max:128',
            'role' => 'required',
            'password' => 'nullable|max:64',
            'passwordVerify' => 'nullable|same:password',
            'tele_id' => [
                'required',
                Rule::unique('admins', 'tele_id')->ignore($id),
            ],
            'tele_username' => [
                 'required',
                Rule::unique('admins', 'tele_username')->ignore($id),
            ]
        ];
    }

    public function messages()
    {
    return [
        'tele_id.unique' => 'This tele id is already taken. Please choose another.',
    ];
    }
}
