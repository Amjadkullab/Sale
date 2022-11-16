<div class="row">
    <div class="col-md-4">
 <div class="form-group">
     <label>   بيانات الأصناف</label>
     <select  id="item_code_add" class="form-control select2" style="width: 100%;">
       <option value="">اختر الصنف</option>
       @if (@isset($item_cards) && !@empty($item_cards))
      @foreach ($item_cards as $info )
        <option data-type="{{ $info->item_type }}" value="{{ $info->item_code }}"> {{ $info->name }} </option>
      @endforeach
       @endif
     </select>

     </div>
 </div>

    <div class="col-md-4 relatied_to_itemCard" id="UomDivAdd" style="display: none;">
 </div>

 <div class="col-md-4  relatied_to_itemCard" id="UomDivAdd" style="display: none;">
     <div class="form-group">
         <label for="">   الكمية المستلمة    </label>
         <input oninput="this.value=this.value.replace(/[^0-9]/g ,'');" value=""  id="quantity_add" class="form-control"  placeholder="أدخل اخر رقم صرف نقدية لهده الخزنة" oninvalid="setCustomValidity('من فضلك أدخل هذا الحقل')" onchange="try{setCustomValidity('')}catch(e){}">

      </div>
      </div>
 <div class="col-md-4  relatied_to_itemCard" style="display: none;">
     <div class="form-group">
         <label for="">    سعر الوحدة    </label>
         <input oninput="this.value=this.value.replace(/[^0-9]/g ,'');" value=""  id="price_add" class="form-control"  placeholder="أدخل اخر رقم صرف نقدية لهده الخزنة" oninvalid="setCustomValidity('من فضلك أدخل هذا الحقل')" onchange="try{setCustomValidity('')}catch(e){}">

      </div>
      </div>
 <div class="col-md-4  relatied_to_date" style="display: none;">
     <div class="form-group">
         <label for="production_date">     تاريخ الانتاج    </label>
         <input  type="date" value=""  id="production_date" class="form-control"  placeholder="أدخل اخر رقم صرف نقدية لهده الخزنة" oninvalid="setCustomValidity('من فضلك أدخل هذا الحقل')" onchange="try{setCustomValidity('')}catch(e){}">

      </div>
      </div>
 <div class="col-md-4  relatied_to_date" style="display: none;">
     <div class="form-group">
         <label for="expire_date">     تاريخ انتهاء الصلاحية    </label>
         <input type="date" value=""  id="expire_date" class="form-control"  placeholder="أدخل اخر رقم صرف نقدية لهده الخزنة" oninvalid="setCustomValidity('من فضلك أدخل هذا الحقل')" onchange="try{setCustomValidity('')}catch(e){}">

      </div>
      </div>
 <div class="col-md-4  relatied_to_itemCard" style="display: none;">
     <div class="form-group">
         <label for="">     الاجمالي    </label>
         <input readonly  oninput="this.value=this.value.replace(/[^0-9]/g ,'');" value=""  id="total_add" class="form-control"  placeholder="أدخل اخر رقم صرف نقدية لهده الخزنة" oninvalid="setCustomValidity('من فضلك أدخل هذا الحقل')" onchange="try{setCustomValidity('')}catch(e){}">

      </div>
      </div>


     <div class="col-md-12">
         <div class="form-group text-center">
         <button type="button" class="btn btn-sm btn-danger" id="AddToBill" data-dismiss="modal">اضف للفاتورة</button>
     </div>
     </div>
 </div>
