<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\ClientOrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TrabajadorController;
use App\Http\Controllers\RatingController;
use App\Models\Orders;

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

Route::get('/', 'App\Http\Controllers\RatingController@index', function () {
    return view('home');
});



Route::post('/payments/pay', 'App\Http\Controllers\PaymentController@pay')->name('pay');
Route::get('/payments/approval', 'App\Http\Controllers\PaymentController@approval')->name('approval');
Route::get('/payments/cancelled', 'App\Http\Controllers\PaymentController@cancelled')->name('cancelled');

Route::resource('category', CategoryController::class)->middleware('auth');
Route::resource('product', ProductController::class)->middleware('auth');


Route::resource('order', OrdersController::class)->middleware('auth');
Route::resource('clientorder', ClientOrderController::class)->middleware('auth');

//Route::resource('cart', CartController::class)->middleware('auth');

//RUTA PARA LA PAGINA PRINCIPAL DE PRODUCTOS
Route::get('/shop', 'App\Http\Controllers\CartController@shop')->name('shop');
Route::get('/shop/{category}', 'App\Http\Controllers\CartController@productByCategory')->name('shop.category');

//RUTA PARA LA VISTA DEL CARRITO
Route::get('/cart', 'App\Http\Controllers\CartController@index')->name('cart.index');

//RUTA PARA AGREGAR PRODUCTOS AL CARRITO
Route::post('/cart/add', 'App\Http\Controllers\CartController@store')->name('cart.store');

//RUTA PARA EDITAR PRODUCTOS DEL CARRITO
Route::post('/cart/update', 'App\Http\Controllers\CartController@update')->name('cart.update');

//RUTA PARA ELIMINAR PRODUCTOS DEL CARRITO
Route::post('/cart/remove', 'App\Http\Controllers\CartController@destroy')->name('cart.destroy');

//RUTA PARA LIMPIAR CARRITO
Route::post('/clear', 'App\Http\Controllers\CartController@clear')->name('cart.clear');


Route::get('/employee/index', 'App\Http\Controllers\EmployeeController@index')->name('employee.index');
Route::post('/employee/register', 'App\Http\Controllers\EmployeeController@regemployee')->name('employee.register')->middleware('auth');
Route::post('/rating/send', 'App\Http\Controllers\RatingController@send')->name('rating.send')->middleware('auth');
Route::get('/employee/destroy/{id}', 'App\Http\Controllers\EmployeeController@destroy')->name('employee.destroy');

Route::get('/employee/create', 'App\Http\Controllers\EmployeeController@create')->name('employee.create')->middleware('auth');




//RUTA PARA GENERAR CONFIRMACION
Route::get('/cart/factura', 'App\Http\Controllers\PaymentController@factura')->name('cart.factura')->middleware('auth');

Route::get('change_status/order/{order}', 'App\Http\Controllers\OrdersController@change_status')->name('change.status.order')->middleware('auth');
Route::get('cancel_order/clientorder/{order}', 'App\Http\Controllers\ClientOrderController@cancel_order')->name('cancel.order')->middleware('auth');

//REPORTES
Route::get('ventas_mes', [OrdersController::class, 'ventas_mes'])->name('ventas_mes')->middleware('auth');
Route::get('ventas_dia', [Orders::class, 'ventas_dia'])->name('ventas_dia')->middleware('auth');
Route::get('venta_producto', [CartController::class, 'venta_producto'])->name('venta_producto')->middleware('auth');
Route::post('ventas/report_results', 'App\Http\Controllers\OrdersController@report_results')->name('report.results')->middleware('auth');

//PDF
Route::get('ventas_mes/pdf/{fi}/{ff}', [OrdersController::class, 'ventaM_pdf'])->name('ventas_mes.pdf')->middleware('auth');
Route::get('ventas_dia/pdf', [OrdersController::class, 'ventaD_pdf'])->name('ventas_dia.pdf')->middleware('auth');
Route::get('venta_producto/pdf', [CartController::class, 'ventaP_pdf'])->name('ventas_producto.pdf')->middleware('auth');


Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('markAsRead', function(){
    auth()->user()->unreadNotifications->markAsRead();
    return redirect()->back();
})->name('markAsRead');

Route::post('/mark-as-read', 'CartController@markNotification')->name('markNotification');
/*
Route::get('/admin', [AdminController::class, 'index'])
    ->middleware('auth.admin')
    ->name('admin.index');

    Route::get('/trabajador', [TrabajadorController::class, 'index'])
    ->middleware('auth.employee')
    ->name('trabajador.index');
*/
