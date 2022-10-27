<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $fillable = [

       'name','account_number','start_balance','start_balance_status','added_by','date','updated_by','com_code','active','current_balance','notes','customer_code','city_id','address'
    ];
}
