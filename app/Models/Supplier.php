<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;
    protected $fillable = [

        'name','account_number','supplier_categories_id','start_balance','start_balance_status','added_by','date','updated_by','com_code','active','current_balance','notes','supplier_code','city_id','address'
     ];
}
