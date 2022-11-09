<div class="form-group">
    <label>   بيانات وحدات الصنف</label>
    <select  id="uom_id_Add" class="form-control select2" style="width: 100%;">
      <option value="">اختر الوحده</option>
      @if (@isset($item_card_data) && !@empty($item_card_data))
    @if($item_card_data['does_has_retailunit']==1)
    <option data-isparentuom="1"   value="{{ $item_card_data['uom_id'] }}"> {{ $item_card_data['parent_uom_name']  }} (وحده اب) </option>
    <option  data-isparentuom="0"   value="{{ $item_card_data['retail_uom_id'] }}"> {{ $item_card_data['retial_uom_name']  }} (وحدة تجزئة) </option>
    @else
    <option   data-isparentuom="1"  value="{{ $item_card_data['uom_id'] }}"> {{ $item_card_data['parent_uom_name']  }} (وحده اب) </option>
    @endif

    @endif 

    </div>
