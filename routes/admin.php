<?php

use App\Http\Controllers\Accounts_Types_Controller;
use App\Http\Controllers\AccountsController;
use App\Models\Admin_panel_setting;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\Inv_UomController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TreasuriesController;
use App\Http\Controllers\Admin_panel_settingsController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admins_ShiftsController;
use App\Http\Controllers\CollectController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ExchangeController;
use App\Http\Controllers\InvItemcardCategorieController;
use App\Http\Controllers\InvItemCardController;
use App\Http\Controllers\Sales_material_typesController;
use App\Http\Controllers\SupplierCategoriesController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\Suppliers_with_ordersController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
define('PAGINATION_COUNT', 4);
// Route::get('/', function () {
//     return view('welcome');
// });
Route::prefix('admin')->middleware('auth:admin')->group(function(){
    Route::get('/',[DashboardController::class,'index'])->name('admin.dashboard');
    Route::get('logout',[AuthController::class,'logout'])->name('admin.logout');
    Route::get('/adminpanelsetting/show',[Admin_panel_settingsController::class,'index'])->name('admin.adminpanelsetting.index');
    Route::get('/adminpanelsetting/edit',[Admin_panel_settingsController::class,'edit'])->name('admin.adminpanelsetting.edit');
    Route::post('/adminpanelsetting/update',[Admin_panel_settingsController::class,'update'])->name('admin.adminpanelsetting.update');

//start treasuries

Route::get('/treasuries/index',[TreasuriesController::class,'index'])->name('admin.treasuries.index');
Route::get('/treasuries/create',[TreasuriesController::class,'create'])->name('admin.treasuries.create');
Route::post('/treasuries/store',[TreasuriesController::class,'store'])->name('admin.treasuries.store');
Route::get('/treasuries/edit/{id}',[TreasuriesController::class,'edit'])->name('admin.treasuries.edit');
Route::post('/treasuries/update/{id}',[TreasuriesController::class,'update'])->name('admin.treasuries.update');
Route::post('/treasuries/ajax_search',[TreasuriesController::class,'ajax_search'])->name('admin.treasuries.ajax_search');
Route::get('/treasuries/details/{id}',[TreasuriesController::class,'details'])->name('admin.treasuries.details');
Route::get('/treasuries/Add_treasuries_delivery/{id}',[TreasuriesController::class,'Add_treasuries_delivery'])->name('admin.treasuries.Add_treasuries_delivery');
Route::post('/treasuries/store_treasuries_delivery/{id}',[TreasuriesController::class,'store_treasuries_delivery'])->name('admin.treasuries.store_treasuries_delivery');
Route::get('/treasuries/delete_treasuries_delivery/{id}',[TreasuriesController::class,'delete_treasuries_delivery'])->name('admin.treasuries.delete_treasuries_delivery');
//end treasuries

//start sales_material_type
Route::get('/sales_material_type/index',[Sales_material_typesController::class,'index'])->name('admin.sales_material_type.index');
Route::get('/sales_material_type/create',[Sales_material_typesController::class,'create'])->name('admin.sales_material_type.create');
Route::post('/sales_material_type/store',[Sales_material_typesController::class,'store'])->name('admin.sales_material_type.store');
Route::get('/sales_material_type/edit/{id}',[Sales_material_typesController::class,'edit'])->name('admin.sales_material_type.edit');
Route::post('/sales_material_type/update/{id}',[Sales_material_typesController::class,'update'])->name('admin.sales_material_type.update');
Route::post('/sales_material_type/ajax_search',[Sales_material_typesController::class,'ajax_search'])->name('admin.sales_material_type.ajax_search');
Route::get('/sales_material_type/delete/{id}',[Sales_material_typesController::class,'delete'])->name('admin.sales_material_type.delete');
//end sales_material_type
//start stores
Route::get('/stores/index',[StoreController::class,'index'])->name('admin.stores.index');
Route::get('/stores/create',[StoreController::class,'create'])->name('admin.stores.create');
Route::post('/stores/store',[StoreController::class,'store'])->name('admin.stores.store');
Route::get('/stores/edit/{id}',[StoreController::class,'edit'])->name('admin.stores.edit');
Route::post('/stores/update/{id}',[StoreController::class,'update'])->name('admin.stores.update');
Route::get('/stores/delete/{id}',[StoreController::class,'delete'])->name('admin.stores.delete');
//end stores

//start Uoms
Route::get('/uoms/index',[Inv_UomController::class,'index'])->name('admin.uoms.index');
Route::get('/uoms/create',[Inv_UomController::class,'create'])->name('admin.uoms.create');
Route::post('/uoms/store',[Inv_UomController::class,'store'])->name('admin.uoms.store');
Route::get('/uoms/edit/{id}',[Inv_UomController::class,'edit'])->name('admin.uoms.edit');
Route::post('/uoms/update/{id}',[Inv_UomController::class,'update'])->name('admin.uoms.update');
Route::get('/uoms/delete/{id}',[Inv_UomController::class,'delete'])->name('admin.uoms.delete');
Route::post('/uoms/ajax_search',[Inv_UomController::class,'ajax_search'])->name('admin.uoms.ajax_search');

//end Uoms
//start inv_itemcard_categorie
Route::resource('/inv_itemcard_categories',InvItemcardCategorieController::class);
//end inv_itemcard_categorie
//start inv_itemcard

Route::get('/inv_itemcard/index',[InvItemCardController::class,'index'])->name('admin.inv_itemcard.index');
Route::get('/inv_itemcard/create',[InvItemCardController::class,'create'])->name('admin.inv_itemcard.create');
Route::post('/inv_itemcard/store',[InvItemCardController::class,'store'])->name('admin.inv_itemcard.store');
Route::get('/inv_itemcard/edit/{id}',[InvItemCardController::class,'edit'])->name('admin.inv_itemcard.edit');
Route::post('/inv_itemcard/update/{id}',[InvItemCardController::class,'update'])->name('admin.inv_itemcard.update');
Route::get('/inv_itemcard/delete/{id}',[InvItemCardController::class,'delete'])->name('admin.inv_itemcard.delete');
Route::post('/inv_itemcard/ajax_search',[InvItemCardController::class,'ajax_search'])->name('admin.inv_itemcard.ajax_search');
Route::get('/inv_itemcard/show/{id}',[InvItemCardController::class,'show'])->name('admin.inv_itemcard.show');

//end inv_itemcard
 //start account types


 Route::get('/accounttypes/index',[Accounts_Types_Controller::class,'index'])->name('admin.accounttypes.index');


//end account types
 //start account
 Route::get('/accounts/index',[AccountsController::class,'index'])->name('admin.accounts.index');
 Route::get('/accounts/create',[AccountsController::class,'create'])->name('admin.accounts.create');
 Route::post('/accounts/store',[AccountsController::class,'store'])->name('admin.accounts.store');
 Route::get('/accounts/edit/{id}',[AccountsController::class,'edit'])->name('admin.accounts.edit');
 Route::post('/accounts/update/{id}',[AccountsController::class,'update'])->name('admin.accounts.update');
 Route::get('/accounts/delete/{id}',[AccountsController::class,'delete'])->name('admin.accounts.delete');
 Route::post('/accounts/ajax_search',[AccountsController::class,'ajax_search'])->name('admin.accounts.ajax_search');
 Route::get('/accounts/show/{id}',[AccountsController::class,'show'])->name('admin.accounts.show');

//end account
 //start customer
 Route::get('/customer/index',[CustomerController::class,'index'])->name('admin.customer.index');
 Route::get('/customer/create',[CustomerController::class,'create'])->name('admin.customer.create');
 Route::post('/customer/store',[CustomerController::class,'store'])->name('admin.customer.store');
 Route::get('/customer/edit/{id}',[CustomerController::class,'edit'])->name('admin.customer.edit');
 Route::post('/customer/update/{id}',[CustomerController::class,'update'])->name('admin.customer.update');
 Route::get('/customer/delete/{id}',[CustomerController::class,'delete'])->name('admin.customer.delete');
 Route::post('/customer/ajax_search',[CustomerController::class,'ajax_search'])->name('admin.customer.ajax_search');
 Route::get('/customer/show/{id}',[CustomerController::class,'show'])->name('admin.customer.show');

//end customer

//start supplier_catigories
Route::get('/supplier_categories/index',[SupplierCategoriesController::class,'index'])->name('admin.supplier_categories.index');
Route::get('/supplier_categories/create',[SupplierCategoriesController::class,'create'])->name('admin.supplier_categories.create');
Route::post('/supplier_categories/store',[SupplierCategoriesController::class,'store'])->name('admin.supplier_categories.store');
Route::get('/supplier_categories/edit/{id}',[SupplierCategoriesController::class,'edit'])->name('admin.supplier_categories.edit');
Route::post('/supplier_categories/update/{id}',[SupplierCategoriesController::class,'update'])->name('admin.supplier_categories.update');
Route::get('/supplier_categories/delete/{id}',[SupplierCategoriesController::class,'delete'])->name('admin.supplier_categories.delete');
//end supplier_catigories
 //start suupllier
 Route::get('/supplier/index',[SupplierController::class,'index'])->name('admin.supplier.index');
 Route::get('/supplier/create',[SupplierController::class,'create'])->name('admin.supplier.create');
 Route::post('/supplier/store',[SupplierController::class,'store'])->name('admin.supplier.store');
 Route::get('/supplier/edit/{id}',[SupplierController::class,'edit'])->name('admin.supplier.edit');
 Route::post('/supplier/update/{id}',[SupplierController::class,'update'])->name('admin.supplier.update');
 Route::get('/supplier/delete/{id}',[SupplierController::class,'delete'])->name('admin.supplier.delete');
 Route::post('/supplier/ajax_search',[SupplierController::class,'ajax_search'])->name('admin.supplier.ajax_search');
 Route::get('/supplier/show/{id}',[SupplierController::class,'show'])->name('admin.supplier.show');

//end suplier
//start supplier order المشتريات
Route::get('/supplier_order/index',[Suppliers_with_ordersController::class,'index'])->name('admin.supplier_order.index');
Route::get('/supplier_order/create',[Suppliers_with_ordersController::class,'create'])->name('admin.supplier_order.create');
Route::post('/supplier_order/store',[Suppliers_with_ordersController::class,'store'])->name('admin.supplier_order.store');
Route::get('/supplier_order/edit/{id}',[Suppliers_with_ordersController::class,'edit'])->name('admin.supplier_order.edit');
Route::post('/supplier_order/update/{id}',[Suppliers_with_ordersController::class,'update'])->name('admin.supplier_order.update');
Route::get('/supplier_order/delete/{id}',[Suppliers_with_ordersController::class,'delete'])->name('admin.supplier_order.delete');
Route::post('/supplier_order/ajax_search',[Suppliers_with_ordersController::class,'ajax_search'])->name('admin.supplier_order.ajax_search');
Route::get('/supplier_order/show/{id}',[Suppliers_with_ordersController::class,'show'])->name('admin.supplier_order.show');
Route::post('/supplier_order/get_item_uoms',[Suppliers_with_ordersController::class,'get_item_uoms'])->name('admin.supplier_order.get_item_uoms');
Route::post('/supplier_order/add_new_details',[Suppliers_with_ordersController::class,'add_new_details'])->name('admin.supplier_order.add_new_details');
Route::post('/supplier_order/load_modal_add_details',[Suppliers_with_ordersController::class,'load_modal_add_details'])->name('admin.supplier_order.load_modal_add_details');
Route::post('/supplier_order/reload_itemsdetails',[Suppliers_with_ordersController::class,'reload_itemsdetails'])->name('admin.supplier_order.reload_itemsdetails');
Route::post('/supplier_order/reload_parent_pill',[Suppliers_with_ordersController::class,'reload_parent_pill'])->name('admin.supplier_order.reload_parent_pill');
Route::post('/supplier_order/load_edit_item_details',[Suppliers_with_ordersController::class,'load_edit_item_details'])->name('admin.supplier_order.load_edit_item_details');
Route::post('/supplier_order/edit_item_details',[Suppliers_with_ordersController::class,'edit_item_details'])->name('admin.supplier_order.edit_item_details');
Route::get('/supplier_order/delete_details/{id}/{id_parent}',[Suppliers_with_ordersController::class,'delete_details'])->name('delete_details');
Route::get('/supplier_order/do_approved/{id}',[Suppliers_with_ordersController::class,'do_approved'])->name('admin.supplier_order.do_approved');
Route::post('/supplier_order/load_modal_approve_invoice',[Suppliers_with_ordersController::class,'load_modal_approve_invoice'])->name('admin.supplier_order.load_modal_approve_invoice');

//end supplier order
//start admin_accounts

Route::get('/admin_accounts/index',[AdminController::class,'index'])->name('admin.admin_accounts.index');
Route::get('/admin_accounts/create',[AdminController::class,'create'])->name('admin.admin_accounts.create');
Route::post('/admin_accounts/store',[AdminController::class,'store'])->name('admin.admin_accounts.store');
Route::get('/admin_accounts/edit/{id}',[AdminController::class,'edit'])->name('admin.admin_accounts.edit');
Route::post('/admin_accounts/update/{id}',[AdminController::class,'update'])->name('admin.admin_accounts.update');
Route::post('/admin_accounts/ajax_search',[AdminController::class,'ajax_search'])->name('admin.admin_accounts.ajax_search');
Route::get('/admin_accounts/details/{id}',[AdminController::class,'details'])->name('admin.admin_accounts.details');
Route::get('/admin_accounts/Add_treasuries_delivery/{id}',[AdminController::class,'Add_treasuries_delivery'])->name('admin.admin_accounts.Add_treasuries_delivery');
Route::post('/admin_accounts/Add_treasuries_to_admin/{id}',[AdminController::class,'Add_treasuries_to_admin'])->name('admin.admin_accounts.Add_treasuries_to_admin');
Route::get('/admin_accounts/delete_treasuries_delivery/{id}',[AdminController::class,'delete_treasuries_delivery'])->name('admin.admin_accounts.delete_treasuries_delivery');
//end admin_accoiunts

//start admin_shifts

Route::get('/admin_shift/index',[Admins_ShiftsController::class,'index'])->name('admin.admin_shift.index');
Route::get('/admin_shift/create',[Admins_ShiftsController::class,'create'])->name('admin.admin_shift.create');
Route::post('/admin_shift/store',[Admins_ShiftsController::class,'store'])->name('admin.admin_shift.store');

//end admin_shifts
//start admin_shifts

Route::get('/collect_transaction/index',[CollectController::class,'index'])->name('admin.collect_transaction.index');
Route::get('/collect_transaction/create',[CollectController::class,'create'])->name('admin.collect_transaction.create');
Route::post('/collect_transaction/store',[CollectController::class,'store'])->name('admin.collect_transaction.store');

//end admin_shifts
Route::get('/exchange_transaction/index',[ExchangeController::class,'index'])->name('admin.exchange_transaction.index');
Route::get('/exchange_transaction/create',[ExchangeController::class,'create'])->name('admin.exchange_transaction.create');
Route::post('/exchange_transaction/store',[ExchangeController::class,'store'])->name('admin.exchange_transaction.store');



});
Route::prefix('admin')->middleware('guest:admin')->group(function(){
    Route::get('login',[AuthController::class,'showlogin'])->name('admin.showlogin');
    Route::post('login',[AuthController::class,'login'])->name('admin.login');


});

