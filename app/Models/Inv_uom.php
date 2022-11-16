<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inv_uom extends Model
{
    use HasFactory;
    protected $fillable = [
        'name','active','is_master','added_by','updated_by','com_code','date',
          ];


          public function inv_itemcards(){
            return $this->hasOne(Inv_itemcard::class);
         }
}
