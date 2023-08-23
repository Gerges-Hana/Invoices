<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\Customers_Report;
use App\Http\Controllers\InvoiceAttachmentsController;
use App\Http\Controllers\invoices_report;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\InvoicesDetailsController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\SectionsController;

// use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
// use App\Http\Controllers\ProductController;

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
Auth::routes();
// notifications
Route::get('/markAsRead',[InvoicesController::class,'markAsRead'])->name('mark');

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/invoices/paid',[ InvoicesController::class,'paid'])->name('paid');
Route::get('/invoices/print/{id}',[ InvoicesController::class,'print'])->name('print');
Route::get('/invoices/unpaid',[ InvoicesController::class,'unpaid'])->name('unpaid');
Route::get('/invoices/partial',[ InvoicesController::class,'partial'])->name('partial');
Route::post('/Status/{id}',[ InvoicesController::class,'Status_Update'])->name('Status_Update');

Route::resource('invoices',InvoicesController::class);
Route::resource('sections',SectionsController::class);
Route::resource('products',ProductsController::class);
Route::resource('archive',ArchiveController::class);



Route::post('/attachment/{id}',[ InvoicesDetailsController::class,'destroy'])->name('delete_file');
Route::get('/section/{id}',[ InvoicesController::class,'getproducts']);
Route::get('/edit_invoice/{id}',[ InvoicesController::class,'edit']);
Route::get('/InvoicesDetails/{id}',[ InvoicesDetailsController::class,'show']);
Route::get('download/{invoice_number}/{file_name}', [ InvoicesDetailsController::class,'get_file']);
Route::get('View_file/{invoice_number}/{file_name}' ,[ InvoicesDetailsController::class,'open_file']);
Route::post('InvoiceAttachments',[InvoiceAttachmentsController::class,'store']);
Route::get('/invoices_report',[invoices_report::class,'index']);
Route::post('/Search_invoices',[invoices_report::class,'Search_invoices']);
Route::get('/customer_report',[Customers_Report::class,'index']);
Route::post('/Search_customer_reportes',[Customers_Report::class,'Search_invoices']);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
});

Route:: get ('/{page}',[AdminController::class,'index']);



