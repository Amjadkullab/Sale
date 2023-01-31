<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admins_Shifts extends Model
{
    use HasFactory;
    protected $table = "admins_shifts";
    protected $fillable = ['id','shift_code','admin_id', 'treasuries_id', 'treasuries_balance_in_shift_start', 'start_date', 'end_date','date', 'is_finished', 'is_delivered_and_reviews', 'delivered_to_admin_id', 'delivered_to_admin_shift_id', 'delivered_to_treasuries_id', 'money_should_delivered', 'what_realy_delivered', 'money_state', 'money_state_value', 'recive_type', 'review_recive_date', 'treasuries_transactions_id', 'added_by', 'created_at','updated_by','updated_at', 'notes', 'com_code'];
}
