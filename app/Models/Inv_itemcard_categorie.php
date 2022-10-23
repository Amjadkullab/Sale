<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inv_itemcard_categorie extends Model
{
    use HasFactory;
    protected $fillable = [
        'name','active','added_by','updated_by','com_code','date',
          ];

     public function inv_itemcards(){
        return $this->hasMany(Inv_itemcard::class);
     }

}
