<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Customers_Report;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoiceArchiveController;
use App\Http\Controllers\Invoices_ReportController;
use App\Http\Controllers\Customers_ReportController;
use App\Http\Controllers\InvoicesAttachmentsController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\InvoicesDetailsController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SectionsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();
// لو عايز اوقف التسجيل
// Auth::routes(['register'=>false]);

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::resource('invoices', InvoicesController::class);

Route::resource('sections', SectionsController::class);

Route::resource('products', ProductsController::class);

Route::get('/section/{id}', [InvoicesController::class, 'getproducts']);

Route::get('/InvoicesDetails/{id}', [InvoicesDetailsController::class, 'edit']);
Route::get('download/{invoice_number}/{file_name}', [InvoicesDetailsController::class, 'get_file']);
Route::get('View_file/{invoice_number}/{file_name}', [InvoicesDetailsController::class, 'open_file']);
Route::post('delete_file', [InvoicesDetailsController::class, 'destroy'])->name('delete_file');

Route::resource('InvoiceAttachments', InvoicesAttachmentsController::class);

Route::get('/edit_invoice/{id}', [InvoicesController::class,'edit']);

Route::get('/Status_show/{id}', [InvoicesController::class,'show'])->name('Status_show');
Route::post('/Status_Update/{id}', [InvoicesController::class,'Status_Update'])->name('Status_Update');

Route::get('invoice_Paid', [InvoicesController::class,'invoice_Paid']);
Route::get('invoice_UnPaid', [InvoicesController::class,'invoice_UnPaid']);
Route::get('invoice_Partial', [InvoicesController::class,'invoice_Partial']);

Route::get('invoice_archive', [InvoiceArchiveController::class,'index']);
Route::resource('Archive', InvoiceArchiveController::class);

Route::get('Print_invoice/{id}', [InvoicesController::class, 'Print_invoice']);

Route::get('export_invoices', [InvoicesController::class, 'export']);

Route::resource('users',UserController::class);
Route::resource('roles',RoleController::class);

Route::get('invoices_report',[Invoices_ReportController::class, 'index']);
Route::post('Search_invoices',[Invoices_ReportController::class, 'Search_invoices']);

Route::get('customers_report',[Customers_ReportController::class, 'index']);
Route::post('Search_Customers',[Customers_ReportController::class, 'Search_customers']);

Route::get('MarkAsRead_all', [InvoicesController::class, 'MarkAsRead_all'])->name('MarkAsRead_all');


Route::get('/{page}', [AdminController::class, 'index']); 