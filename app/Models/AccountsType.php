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

   public function accounts(){
    return $this->hasMany(Account::class);
   }


}
