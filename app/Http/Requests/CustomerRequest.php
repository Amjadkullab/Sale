<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
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
            'start_balance_status'=> 'required',
            'start_balance'=> 'required|min:0',
            'active'=> 'required'


        ];
    }


    public function messages(){


        return [
            'name.required'=> 'اسم العميل مطلوب',
            'start_balance_status.required'=> 'حالة رصيد الحساب اول المدة مطلوب',
            'start_balance.required'=> 'رصيد أول المدة للحساب مطلوب',
            'is_archived.required'=> 'حالة تفعيل حساب العميل مطلوبة',

        ];





    }
}
