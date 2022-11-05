<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class suppliers_with_orders_detail extends Model
{
    use HasFactory;
    protected $fillable = ['suppliers_with_orders_auto_serial', 'order_type', 'com_code', 'deliverd_quantity', 'uom_id', 'isMain_retail_uom', 'unit_price', 'total_price', 'order_date', 'added_by', 'updated_by', 'item_code'];
}
