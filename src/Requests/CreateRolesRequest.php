<?php

namespace ViralsInfyom\ViralsPermission\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateRolesRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|unique:roles,name|max:191',
            'permissions.*' => 'required'
        ];
    }
}
