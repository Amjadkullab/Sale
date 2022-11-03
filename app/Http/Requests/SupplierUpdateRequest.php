<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupplierUpdateRequest extends FormRequest
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
            'supplier_categories_id'=>'required',
            'active'=> 'required',


        ];
    }


    public function messages(){


        return [
            'name.required'=> 'اسم المورد مطلوب',
            'supplier_categories_id.required'=>'فئة المورد مطلوبة',
             'active.required'=>'حالة تفعيل المورد مطلوبة',


        ];





    }
}
