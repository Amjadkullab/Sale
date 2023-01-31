<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Treasuries_transactions extends Model
{
    use HasFactory;
    protected $table = "treasuries_transactions" ;
    protected $fillable = ['auto_serial','isal_number','treasuries_id', 'mov_type', 'move_date','the_foregin_key', 'account_number', 'is_account', 'is_approved', 'shift_code', 'money', 'money_for_account', 'byan', 'created_at', 'added_by', 'updated_at', 'updated_by', 'com_code'];

}
