<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required', 'max:255', 
                Rule::unique('tasks')
                ->where(function ($query) {
                    return $query->where('check_list_id', $this->check_list->id);
                })
            ],
            'description' => [
                'required',
                'max:800'
            ]
        ];
    }
}
