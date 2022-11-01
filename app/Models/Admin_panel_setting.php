<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin_panel_setting extends Model
{
    use HasFactory;
    protected $fillable =[
        'system_name','photo','active','general_alert','address','phone','added_by','updated_by','com_code','customer_parent_account_number','supplier_parent_account_number'
    ];
}
