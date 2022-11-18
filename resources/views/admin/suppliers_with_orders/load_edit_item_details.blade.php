@if (!@empty($parent_pill_data))
 @if($parent_pill_data['is_approved']==0)
 @if(!@empty($item_data_details))


 <div class="row">
    <div class="col-md-4">
 <div class="form-group">
     <label>   بيانات الأصناف</label>
     <select  id="item_code_add" class="form-control select2" style="width: 100%;">
       <option value="">اختر الصنف</option>
       @if (@isset($item_cards) && !@empty($item_cards))
      @foreach ($item_cards as $info )
        <option @if($item_data_details['item_code']==$info->item_code) selected="selected" @endif data-type="{{ $info->item_type }}" value="{{ $info->item_code }}"> {{ $info->name }} </option>
      @endforeach
       @endif
     </select>

     </div>
 </div>

    <div class="col-md-4 relatied_to_itemCard" id="UomDivAdd" >
        <div class="form-group">
            <label>   بيانات وحدات الصنف</label>
            <select  id="uom_id_Add" class="form-control select2" style="width: 100%;">
              <option value="">اختر الوحده</option>
              @if (@isset($item_card_data) && !@empty($item_card_data))
            @if($item_card_data['does_has_retailunit']==1)
            <option @if($item_card_data['uom_id']==$item_data_details['uom_id'])selected @endif data-isparentuom="1"   value="{{ $item_card_data['uom_id'] }}"> {{ $item_card_data['parent_uom_name']  }} (وحده اب) </option>
            <option  @if($item_card_data['retail_uom_id']==$item_data_details['retail_uom_id'])selected @endif   data-isparentuom="0"   value="{{ $item_card_data['retail_uom_id'] }}"> {{ $item_card_data['retial_uom_name']  }} (وحدة تجزئة) </option>
            @else
            <option   data-isparentuom="1"  value="{{ $item_card_data['uom_id'] }}"> {{ $item_card_data['parent_uom_name']  }} (وحده اب) </option>
            @endif

            @endif

            </div>

 </div>

 <div class="col-md-4  relatied_to_itemCard" id="UomDivAdd" style="display: none;">
    <div class="form-group">
        <label for="">   الكمية المستلمة    </label>
        <input oninput="this.value=this.value.replace(/[^0-9]/g ,'');" value=""  id="quantity_add" class="form-control"  placeholder="أدخل اخر رقم صرف نقدية لهده الخزنة" oninvalid="setCustomValidity('من فضلك أدخل هذا الحقل')" onchange="try{setCustomValidity('')}catch(e){}">

     </div>
     </div>
 <div class="col-md-4  relatied_to_itemCard" >
     <div class="form-group">
         <label for="">    سعر الوحدة    </label>
         <input oninput="this.value=this.value.replace(/[^0-9]/g ,'');" value="{{$item_data_details['deliverd_quantity']*1}}"    id="price_add" class="form-control"  placeholder="أدخل اخر رقم صرف نقدية لهده الخزنة" oninvalid="setCustomValidity('من فضلك أدخل هذا الحقل')" onchange="try{setCustomValidity('')}catch(e){}">

      </div>
      </div>
 <div class="col-md-4  relatied_to_date" @if($item_data_details['item_card_type']!= 2) style="display: none;" @endif>
     <div class="form-group">
         <label for="production_date">     تاريخ الانتاج    </label>
         <input  type="date"  value="{{$item_data_details['production_date']}}"  id="production_date" class="form-control"  placeholder="أدخل اخر رقم صرف نقدية لهده الخزنة" oninvalid="setCustomValidity('من فضلك أدخل هذا الحقل')" onchange="try{setCustomValidity('')}catch(e){}">

      </div>
      </div>
 <div class="col-md-4  relatied_to_date" @if($item_data_details['item_card_type'] != 2) style="display: none;" @endif>
     <div class="form-group">
         <label for="expire_date">     تاريخ انتهاء الصلاحية    </label>
         <input type="date"  value="{{$item_data_details['expire_date']}}"id="expire_date" class="form-control"  placeholder="أدخل اخر رقم صرف نقدية لهده الخزنة" oninvalid="setCustomValidity('من فضلك أدخل هذا الحقل')" onchange="try{setCustomValidity('')}catch(e){}">

      </div>
      </div>
 <div class="col-md-4  relatied_to_itemCard" >
     <div class="form-group">
         <label for="">     الاجمالي    </label>
         <input readonly  oninput="this.value=this.value.replace(/[^0-9]/g ,'');" value="{{$item_data_details['total_price']*1}}"  id="total_add" class="form-control"  placeholder="أدخل اخر رقم صرف نقدية لهده الخزنة" oninvalid="setCustomValidity('من فضلك أدخل هذا الحقل')" onchange="try{setCustomValidity('')}catch(e){}">

      </div>
      </div>

      <div class="col-md-12">
        <div class="form-group text-center">
        <button data-id={{$item_data_details['id']}} type="button" class="btn btn-sm btn-danger" id="EditDetailsitem" data-dismiss="modal">تعديل للفاتورة</button>
    </div>
    </div>
     </div>




 @else
 <div class="alert alert-danger">
عفوا غير قادر للوصول للبيانات المطلوبة
 </div>

 @endif


 @else
 <div class="alert alert-danger">
     عفوا لا يممكن تحديث فاتورة معتمدة ومؤرشفة !!
 </div>

 @endif


 @else
 <div class="alert alert-danger">
     عفوا لا يوجد بيانات لعرضها !!
 </div>

 @endif
