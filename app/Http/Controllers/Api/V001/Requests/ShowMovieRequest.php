<?php
namespace App\Http\Controllers\Api\V001\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ShowMovieRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Adjust as needed
    }

    public function rules()
    {
        return [
            'id' => 'required|exists:movies,id',
        ];
    }
    protected function prepareForValidation()
    {
        $this->merge(['id' => $this->route('id')]); // assuming 'movie' is the route parameter name for movie id
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
