<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inv_itemcard extends Model
{
    use HasFactory;
    protected $fillable = [
        'name','item_type','inv_itemcard_categories_id','parent_inv_itemcard_id','does_has_retailunit','retail_uom','uom_id',
 'retail_uom_quntToParent','added_by','updated_by','has_fixed_price','cost_price','cost_price_retail','com_code','date','active','item_code','barcode',
 'price','nos_gomla_price','gomla_price','price_retail','nos_gomla_price_retail','gomla_price_retail','QUENTITY','
 QUENTITY_Retail','QUENTITY_all_Retail','photo','retail_uom_id'];


   public function inv_item_categorie(){
    return $this->belongsTo(Inv_itemcard_categorie::class);
   }

   public function inv_uom(){
    return $this->belongsTo(Inv_uom::class);
   }



}
