<?php
namespace App\Http\Controllers\Api\V001\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
class SerachMovieRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Adjust as needed
    }

    public function rules()
    {
        return [
            'search' => 'nullable|string',
            'genre' => 'nullable|string',
            'per_page' => 'nullable|numeric'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => 422,
            'message' => 'Validation error',
            'errors' => $validator->errors(),
            'data' => null,
        ], 422));        
    }
}
