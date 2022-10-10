<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCheckListRequest extends FormRequest
{
    protected $errorBag = 'storelist';
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
                    ->ignore($this->check_list->id)
            ],
            'description' => [
                'required',
                'max:500'
            ]
        ];
    }
}
