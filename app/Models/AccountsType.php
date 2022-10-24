<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountsType extends Model
{
    use HasFactory;

   protected $fillable = [
'name','active','relatediternalaccounts'
   ];

   public function Accounts(){
    return $this->hasmany(Account::class,'account_types_id','id');
   }


}
