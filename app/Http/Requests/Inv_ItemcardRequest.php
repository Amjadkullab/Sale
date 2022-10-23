<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Inv_ItemcardRequest extends FormRequest
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
            'item_type'=> 'required',
            'inv_itemcard_categories_id'=>'required',
            'uom_id'=>'required',
            'does_has_retailunit'=>'required',
            'retail_uom_id'=>'required_if:does_has_retailunit,1',
            'retail_uom_quntToParent'=>'required_if:does_has_retailunit,1',
            'price'=> 'required',
            'nos_gomla_price'=> 'required',
            'gomla_price'=> 'required',
            'cost_price'=> 'required',
            'price_retail'=> 'required_if:does_has_retailunit,1',
            'nos_gomla_price_retail'=> 'required_if:does_has_retailunit,1',
            'gomla_price_retail'=> 'required_if:does_has_retailunit,1',
            'cost_price_retail'=> 'required_if:does_has_retailunit,1',
            'has_fixed_price'=>'required',
            'active'=>'required'

        ];
    }
    public function messages(){
        return [
            'name.required'=>'اسم الصنف مطلوب',
            'item_type.required'=>'نوع الصنف مطلوب',
            'inv_itemcard_categories_id.required' => 'فئة الصنف مطلوب',
            'uom_id.required' => 'وحدة القياس الاساسية للصنف مطلوب',
            'does_has_retailunit.required' => 'حالةهل للصنف وحدة تجزئة مطلوب ',
            'retail_uom_id.required_if' => 'وحدة التجزئة مطلوبة',
            'retail_uom_quntToParent.required_if' => 'عدد وحدات التجزئة مطلوبة',
            'price.required'=> 'السعر القطاعي للوحدة الاب مطلوب',
            'nos_gomla_price.required'=> ' سعر النص جملة للوحدة الاب مطلوب',
            'gomla_price.required'=> ' سعر  الجملة للوحدة الاب مطلوب',
            'cost_price.required'=> ' سعر  تكلفة الشراء  للوحدة الاب مطلوب',
            'price_retail.required_if'=> ' سعر  القطاعي للتجزئة  مطلوب',
            'nos_gomla_price_retail.required_if'=> ' سعر نص جملة  للوحدة التجزئة مطلوب',
            'gomla_price_retail.required_if'=> ' سعر  جملة  للوحدة التجزئة مطلوب',
            'cost_price_retail.required_if'=> ' سعر تكلفة الشراء  للوحدة التجزئة مطلوب',
            'has_fixed_price.required' => 'حالة هل للصنف سعر ثابت مطلوب',
            'active.required' => 'حالة تفعيل الصنف مطلوبة',

        ];
    }
}

