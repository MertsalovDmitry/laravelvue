<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeRequest extends FormRequest
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
            'lastname'   => 'required|min:2|max:30',
            'firstname'  => 'required|min:2|max:30',
            'middlename' => 'required|min:2|max:30',
            'salary' => 'required',
            'employed_at' => 'required|date_format:"Y-m-d"',
            'position_id' => 'required',
            'parent_id' => ''
        ];
    }

    /**
    * Get the error messages for the defined validation rules.
     *
    * @return array
    */
    public function messages()
    {
        return [
            'lastname.required'    => 'Поле Фамилия обязательно.',
            'firstname.required'    => 'Поле Имя обязательно.',
            'middlename.required'    => 'Поле Отчество обязательно.',
            'salary.required'    => 'Поле Зарплата обязательно.',
            'employed_at.required'    => 'Поле Принят обязательно.',
            'position_id.required'    => 'Поле Должность обязательно.',
            'lastname.min'    => 'Поле Фамилия должно быть не меньше :min символов.',
            'firstname.min'    => 'Поле Имя должно быть не меньше :min символов.',
            'middlename.min'    => 'Поле Отчество должно быть не меньше :min символов.',
            'lastname.max' => 'Поле Фамилия должно быть не больше :max символов.',
            'firstname.max' => 'Поле Имя должно быть не больше :max символов.',
            'middlename.max' => 'Поле Отчество должно быть не больше :max символов.',
        ];
    }
}
