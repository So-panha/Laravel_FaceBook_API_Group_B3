<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends DefaultRequest
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
            'caption' => 'required|string',
            'image.*' => 'required|file|mimes:jpeg,png,jpg,gif|max:2048',
            'video.*' => 'required|file|mimes:mp4,mov,avi,mkv,flv,wmv|max:100000',
        ];
    }
}
