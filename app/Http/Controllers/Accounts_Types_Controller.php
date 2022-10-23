<?php

namespace App\Http\Controllers;

use App\Models\AccountsType;
use Illuminate\Http\Request;

class Accounts_Types_Controller extends Controller
{
    public function index(){

    $data = AccountsType::select()->orderby('id','ASC')->get();

    return view('admin.accounts_types.index',['data'=>$data]);





    }
}
