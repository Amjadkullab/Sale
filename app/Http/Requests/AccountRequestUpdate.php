<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccountRequestUpdate extends FormRequest
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


            'name'=> 'required',
            'account_types_id'=> 'required',
            'is_parent'=> 'required',
            'parent_account_number'=> 'required_if:is_parent,0',
            'is_archived'=> 'required'


        ];
    }



    public function messages(){


        return [
            'name.required'=> 'اسم الحساب مطلوب',
            'account_types_id.required'=> 'نوع الحساب مطلوب',
            'is_parent.required'=> 'هل الحساب أب مطلوب',
            'parent_account_number.required_if'=> 'الحساب الاب مطلوب',
            'is_archived.required'=> 'حالة تفعيل الحساب مطلوبة',

        ];





    }
}
