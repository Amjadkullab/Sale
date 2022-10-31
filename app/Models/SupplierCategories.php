<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierCategories extends Model
{
    use HasFactory;
    protected $fillable = [
        'name','active','added_by','updated_by','com_code','date',
          ];
}
