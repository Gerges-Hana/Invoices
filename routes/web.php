<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\InvoiceAttachmentsController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\InvoicesDetailsController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\SectionsController;

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




Route::get('/', function () {
    return view('auth.login');
});

// Route::get('/{page}', 'AdminController@index');

Auth::routes();

Route::resource('invoices',InvoicesController::class);
Route::resource('sections',SectionsController::class);
Route::resource('products',ProductsController::class);
Route::get('/section/{id}',[ InvoicesController::class,'getproducts']);
Route::post('/Status/{id}',[ InvoicesController::class,'Status_Update'])->name('Status_Update');
Route::get('/edit_invoice/{id}',[ InvoicesController::class,'edit']);
Route::get('/InvoicesDetails/{id}',[ InvoicesDetailsController::class,'edit']);
Route::post('/attachment/{id}',[ InvoicesDetailsController::class,'destroy'])->name('delete_file');
Route::get('download/{invoice_number}/{file_name}', [ InvoicesDetailsController::class,'get_file']);
Route::get('View_file/{invoice_number}/{file_name}' ,[ InvoicesDetailsController::class,'open_file']);
Route::post('InvoiceAttachments',[InvoiceAttachmentsController::class,'store']);


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Route::group(['middleware' => ['auth']], function() {
//     Route::resource('roles', RoleController::class);
//     Route::resource('users', UserController::class);
//     Route::resource('products', ProductController::class);
// });

Route:: get ('/{page}',[AdminController::class,'index']);
