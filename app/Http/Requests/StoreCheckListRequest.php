<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCheckListRequest extends FormRequest
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
                Rule::unique('check_lists')
                ->where(function ($query) {
                    return $query->where('check_list_group_id', $this->check_list_group->id);
                })
            ],
            'description' => [
                'required',
                'max:500'
            ]
        ];
    }
}
