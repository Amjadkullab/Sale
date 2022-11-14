<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class suppliers_with_orders_detail extends Model
{
    use HasFactory;
    protected $fillable = ['suppliers_with_orders_auto_serial', 'order_type', 'com_code', 'deliverd_quantity', 'batch_id','uom_id','item_card_type', 'total_cost_items','isparentuom', 'unit_price', 'total_price', 'order_date', 'added_by', 'updated_by','production_date','expire_date', 'item_code'];
}
