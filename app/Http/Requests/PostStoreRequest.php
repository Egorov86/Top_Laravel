<?php

namespace App\Http\Requests;

use App\Rules\LanguageRule;
use Illuminate\Foundation\Http\FormRequest;

class PostStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $request = request();

        switch ($request->method()) {
            case 'POST':
                return [
                    'content' => [
                        'required',
                        'string',
                        'min:2',
                        'max:255',
//                        new LanguageRule()
                    ],
                    'category_id' => [
                        'exists:categories,id',
                        'required'
                    ]
                ];
            case 'PUT':
                return [
                    'content' => [
                        'required',
                        'string',
                        'min:2',
                        'max:255',
//                        new LanguageRule()
                    ],
                    'category_id' => [
                        'exists:categories,id',
                        'required'
                    ],
                    'tags' => [
                        'array',
                    ]
                ];
            case 'DELETE':
                return [];
        }

        return [
            'content' => 'required|string|max:500|min:10',
        ];
    }

    public function messages(): array
    {
        $request = request();
        if ($request->method() === 'POST') {
            return [
                'content.max' => 'Максимальное количество символов 10.',
                'content.min' => 'Минимальное количество символов 5.',
            ];
        }elseif ($request->method() === 'PUT')
        {
            return [
                'content.max' => 'Максимальное количество символов 500.',
                'content.min' => 'Минимальное количество символов 10.',
            ];

        }elseif ($request->method() === 'DELETE'){
            return [
            ];
        }else{
            throw new \Exception('Method not allowed');
        }
    }
}
