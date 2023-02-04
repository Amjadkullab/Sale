@if (@isset($data) && !@empty($data))


@if($data['is_approved']==0)
<div class="row">
<div class="col-md-6">
<div class="form-group">
    <label for="">اجمالي الاصناف  بالفاتورة</label>
    <input  readonly oninput="this.value=this.value.replace(/[^0-9]/g,'');" class="form-control" id="total_cost_items" value="{{ $data['total_cost_items']}}">

</div>
</div>
<div class="col-md-6">
<div class="form-group">
    <label for="">   نسبة ضريبة القيمة المضافة</label>
    <input oninput="this.value=this.value.replace(/[^0-9]/g,'');" class="form-control" id="tax_percent" value="{{ $data['tax_percent']}}">

</div>
</div>
<div class="col-md-6">
<div class="form-group">
    <label for="">    قيمة الضريبة المضافة</label>
    <input  readonly class="form-control" id="tax_value" value="{{ $data['tax_value']}}">

</div>
</div>
<div class="col-md-6">
<div class="form-group">
    <label for="">   قيمة الاجمالي قبل الخصم   </label>
    <input  readonly class="form-control" id="total_before_discount" value="{{ $data['total_before_discount']}}">

</div>
</div>
<div class="col-md-6">
<div class="form-group">
    <label for="discount_type">  نوع الخصم ان  وجد</label>
<select class="form-control" name="discount_type" id="discount_type">
    <option value="">من فضلك اختر نوع الخصم</option>
    <option value="1" @if($data['discount_type']==1) selected @endif> نسبة مئوية </option>
    <option value="2" @if($data['discount_type']==2) selected @endif>   قيمة يدوي </option>
</select>
</div>
</div>
<div class="col-md-6">
<div class="form-group">
    <label for="">   نسبة الخصم</label>
    <input oninput="this.value=this.value.replace(/[^0-9]/g,'');" class="form-control" id="discount_percent" value="{{ $data['discount_percent']}}">

</div>
</div>
<div class="col-md-6">
<div class="form-group">
    <label for="">   قيمة الخصم</label>
    <input  readonly  class="form-control" id="discount_value" value="{{ $data['discount_value']}}">

</div>
</div>
<div class="col-md-6">
<div class="form-group">
    <label for="">    الاجمالي النهائي بعد الخصم</label>
    <input  readonly  class="form-control" id="total_cost" value="{{ $data['total_cost']}}">

</div>
</div>
</div>


@else
<div class="alert alert-danger">
    عفوا لقد تم اعتماد الفاتورة من قبل !!
</div>
@endif










@else
<div class="alert alert-danger">
    عفوا لا يوجد بيانات لعرضها!!
</div>
       @endif
