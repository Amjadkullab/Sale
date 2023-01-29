<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Treasuries_transactions extends Model
{
    use HasFactory;
    protected $table = "treasuries_transactions" ;
    protected $fillable = ['treasuries_id', 'mov_type', 'the_foregin_key', 'account_number', 'is_account', 'is_approved', 'admins_shifts_id', 'money', 'money_for_account', 'byan', 'created_at', 'added_by', 'updated_at', 'updated_by', 'com_code'];

}
