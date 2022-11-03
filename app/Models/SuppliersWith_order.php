<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuppliersWith_order extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_type', 'auto_serial', 'DOC_NO', 'order_date', 'supplier_code', 'is_approved', 'com_code', 'notes', 'discount_type', 'discount_percent', 'discount_value', 'tax_percent', 'tax_value', 'total_before_discount', 'total_cost', 'account_number', 'money_for_account', 'pill_type', 'what_paid', 'what_remain', 'trasuries_transaction_id', 'supplier_balance_before', 'supplier_balance_after', 'added_by', 'updated_by'
          ];
}
