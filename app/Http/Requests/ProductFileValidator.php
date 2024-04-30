<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class ProductFileValidator extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * @return bool
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
            'file' => [
                'bail', // Pára a validação na primeira falha
                'required', // O arquivo é obrigatório
                'file', // Deve ser um arquivo
                'mimes:csv', // Deve ter a extensão .csv
                'max:25600', // Tamanho máximo do arquivo (25 MB)
                'min:1', // Tamanho mínimo do arquivo (1 byte)
                'filled', // Deve ter um valor preenchido
            ],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.*
     * @param Validator $validator
     * @return void
     */
    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(
            response(
                [
                    'errors' => $validator->errors(),
                    'status' => true
                ],
                Response::HTTP_UNPROCESSABLE_ENTITY
            )
        );
    }
}
