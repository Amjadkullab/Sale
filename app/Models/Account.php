<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;
 protected $fillable=[
 'name','account_types_id','parent_account_number','account_number','start_balance','added_by','date','updated_by','last_update','com_code'
  ,'is_archived','current_balance','notes','other_table_FK','is_parent'
 ];
 public function accounttype(){
    return $this->belongsTo(AccountsType::class);
 }



}
