<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfielRequest extends DefaultRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
            'birthday' => 'required|string',
            'place' => 'required|string',
            'bio' =>'required|string|'
        ];
    }
}
