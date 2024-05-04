<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
// use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\Validator as ValidatorFacade;
use Illuminate\Contracts\Validation\Validator as ValidatorContract;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class CreateOrderRequest extends FormRequest
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
            'name' => 'required|string',
            'delivery_at' => 'required|date',
            'products' => [
                'required',
                'array',
                function ($attribute, $value, $fail) {
                    $rules = [
                        'id' => 'required|string',
                        'quantity' => 'required|integer|min:1',
                    ];

                    foreach ($value as $product) {
                        $validator = ValidatorFacade::make($product, $rules);

                        if ($validator->fails()) {
                            $fail('Cada item na lista de produtos deve ter um ID e uma quantidade.');
                            return;
                        }
                    }
                }
            ],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.*
     * @param ValidatorContract $validator
     * @return void
     */
    protected function failedValidation(ValidatorContract $validator): void
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
