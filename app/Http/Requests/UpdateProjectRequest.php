<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProjectRequest extends FormRequest
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
            'title' => [
                'required',
                'string',
                'max:150',
                'min:1',
                Rule::unique('projects', 'title')->ignore($this->project) //vedi docs
            ],
            'description' => 'required|string|max:3000|min:10',
            'website_link' => 'nullable|string|url',
            'source_code_link' => 'nullable|string|url',
            'proj_category' => [
                'required',
                'max:100',
                Rule::in([
                    'frontend', 'backend', 'fullstack'
                ])
            ],
            'type_id' => 'nullable|exists:types,id',
            'client' => 'required|string|max:100|min:2',
            'client_category' => [
                'required',
                'max:100',
                Rule::in([
                    'food-and-beverage', 'fashion', 'tech'
                ])
            ],
            'techs' => 'exists:technologies,id'
        ];
    }
}
