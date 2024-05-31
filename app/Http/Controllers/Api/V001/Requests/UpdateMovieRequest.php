<?php
namespace App\Http\Controllers\Api\V001\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateMovieRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Adjust as needed
    }

    public function rules()
    {
        return [
            'id' => 'required|exists:movies,id',
            'pos' => 'required|numeric',
            'year_2023' => 'required|string',
            'year_2022' => 'required|string',
            'title' => 'required|string',
            'director' => 'required|string',
            'year' => 'required|string',
            'country' => 'required|string',
            'length' => 'required|string',
            'genre' => 'required|string',
            'colour' => 'required|string',
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
